<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendDiscordMessage;
use App\Jobs\TranslateParagraphForBook;
use App\Jobs\TranslateBook;
use App\User;
use App\Mail\TranslationOrdered;

class OrderController extends Controller
{
    
    public function complete(Request $request, $orderId) {
        
        $order = null;
        
        if(isset($orderId)) {
            
            $order = \App\Order::findOrFail($orderId);
            
        } else if(isset($request->session_id)) {
            
            $order = \App\Order::where('stripe_session_id', '=', $request->session_id)->first(); 
            
        }
        
        if(!isset($order)) {
            
            abort(404);
            
        }
            
        $book = $order->getBook();
        
        // The locale was originally set here because mail is done in a queue 
        // (which doesn't hold the session data of the user very well.) It doesn't
        // actually have to be passed, because $order->getLocale() is a method already.
        
        // However, it currently is. And since mail was sharing a section of the blade
        // template below, they both needed the same variable... However, now mail isn't
        // sharing that same locale anymore. Revisiting using the same template in the future
        // might be a good idea... but mail is complicated because it can't just be regular html.
        
        $locale = $request->session()->get('locale');
        
        return view('order/review', compact('order', 'book', 'locale'));
        
    }
    
    public function checkout($translation_book_id) {
        
        $translationBook = \App\BookTranslation::findOrFail($translation_book_id);
        
        $book = \App\Book::find($translationBook->book);
        
        if(!$book->userHasAccess()) {
            
            return redirect()->back()->with('danger', __('no_access_error_message.error'));
            
        }
        
        
        // Set your secret key. Remember to switch to your live secret key in production!
        // See your keys here: https://dashboard.stripe.com/account/apikeys
        \Stripe\Stripe::setApiKey(config('stripe_keys.api_key'));
        
        $product = \Stripe\Product::create([
            'name' => $book->title,
            'description' => $book->getLanguage()->language . ' to ' . $translationBook->getLanguage()->language . ' Translation',
        ]);
        
        $price = \Stripe\Price::create([
            'product' => $product,
            'unit_amount' => $translationBook->getPricing() * 100, // Stripe's API is in cents.
            'currency' => 'usd',
        ]);
        
        $user = null;
        
        if(Auth::check()) {
            
            $user = \App\User::find(Auth::id());
            
        }
        
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price' => $price,
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => url('/purchase/complete?session_id={CHECKOUT_SESSION_ID}'),
            'cancel_url' => url('/order/' . $translation_book_id),
            'customer_email' => isset($user) ? $user->email : null,
        ]);
        
        $order = new \App\Order();
        
        $order->stripe_session_id = $session->id;
        $order->state = 'pending';
        $order->book_translation = $translationBook->id;
        
        // save session
        
        if(isset($user)) {
            
            // add this potential purchase to their account
            
            $order->user = $user->id;
            
        }
        
        if($order->save()) {
            
            return view('order/checkout', compact('translationBook', 'book', 'session'));
            
        } else {
            
            return redirect()->back()->with('danger', 'There was a problem connecting to our payment processor. Please try again.');
            
        }
        
    }
    
    public function confirmOrder() {
        
        // Set your secret key. Remember to switch to your live secret key in production!
        // See your keys here: https://dashboard.stripe.com/account/apikeys
        \Stripe\Stripe::setApiKey(config('stripe_keys.api_key'));
        
        // You can find your endpoint's secret in your webhook settings
        $endpoint_secret = config('stripe_keys.endpoint_secret');
        
        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;
        
        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
                );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            http_response_code(400);
            exit();
        }
        
        // Handle the checkout.session.completed event
        if ($event->type == 'checkout.session.completed') {
            $session = $event->data->object;
            
            $order = \App\Order::where('stripe_session_id', '=', $session->id)->first();
            
            if(isset($order)) {
                
                $order->state = 'complete';
                
                $translationBook = $order->getBook();
                
                // It would probably be a good idea to refund the user if someone else
                // purchased it before them.
                if(!$translationBook->hasTranslation()) {
                    
                    $translationBook->has_translation = true;
                    $book = $translationBook->getBook();
                    
                    // Complete won't be set if the queue isn't being used
                    TranslateBook::dispatch($translationBook, $book, true)->onQueue('default_long');
                    
                    
                    if($order->hasUser()) {
                        
                        Mail::to($order->getContact())->queue((new TranslationOrdered($order))->onQueue('mail'));
                        
                    } else {
                        
                        // This is the email that stripe collected when the person was checking out.
                        // It actually might be a good idea to store this with the order... Though
                        // it isn't being done at the moment.
                        
                        Mail::to($session->customer_email)->queue((new TranslationOrdered($order))->onQueue('mail'));
                        
                    }
                    
                    // I want to be notified when someone is using google cloud 
                    Mail::to('admin@admin.com')->queue((new TranslationOrdered($order))->onQueue('mail'));
                   
                    if($order->save() && $translationBook->save()) {
                        
                        http_response_code(200);
                        
                        exit();
                        
                    } else {
                        
                        http_response_code(500);
                        exit();
                        
                    }
                    
                }
                
            } else {
                
                http_response_code(500);
                exit();
                
                // We do not know what the customer purchased...
                
            }
            
        }
        
        http_response_code(200);
        exit();
        
    }
    
    public function adminOrderBook(Request $request) {
        
        
        $isReal = (bool)$request->isReal;
        
        $bookTranslation = \App\BookTranslation::findOrFail($request->bookTranslationId);
        $book = $bookTranslation->getBook();
        
        \App\Jobs\TranslateBook::dispatch($bookTranslation, $book, $isReal)->onQueue('default_long');
        
        if(!$isReal) {
            
            $msg = $book->getTitle() . ' is having it\'s translation faked!';
            
        } else {
            
            $msg = 'You literally just spent $' . $bookTranslation->getPricing() . ' on ' . $book->getTitle() . '.';
            
        }
        
        $order = new \App\Order();
        $order->state = 'complete';
        $order->user = Auth::id();
        $order->book_translation = $bookTranslation->id;
        
        if($order->save()) {
            
            Mail::to('admin@admin.com')->queue((new TranslationOrdered($order))->onQueue('mail'));
            
        }
        
        return redirect('/l/' . $bookTranslation->getLanguage()->abbreviation . '/' . $book->getLanguage()->abbreviation)->with('success', 'This book is now being translated.');
        
    }
    
    
}
