<?php

namespace App\Mail;

use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TranslationOrdered extends Mailable
{
    use Queueable, SerializesModels;
    
    protected $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $order = $this->order;
        $locale = $this->order->getLocale();
        $book = $this->order->getBook();
        
        $this->withSwiftMessage(function ($message) {
            $message->getHeaders()->addTextHeader('Content-Type', 'text/html; charset=8bit');
            
            // https://luke.nehemedia.de/2014/03/25/laravel-emails-mit-8bit-content-transfer-encoding-senden/
            // https://web.archive.org/web/20170820183700/https://luke.nehemedia.de/2014/03/25/laravel-emails-mit-8bit-content-transfer-encoding-senden/
            
            // https://swiftmailer.symfony.com/docs/messages.html#setting-the-character-set
            // https://web.archive.org/web/20191008094801/https://swiftmailer.symfony.com/docs/messages.html
            
            //$eightBitMime = new \Swift_Transport_Esmtp_EightBitMimeHandler();
            //$transport->setExtensionHandlers([$eightBitMime]); 
           
            $plainEncoder = new \Swift_Mime_ContentEncoder_PlainContentEncoder('8bit'); 
            $message->setEncoder($plainEncoder);
        });
        
        $subject = __('mail_7-6-20.subject', [], $locale);
        
        return $this->subject($subject)->view('order/mail_review', compact('order', 'locale', 'book'));
    }
}
