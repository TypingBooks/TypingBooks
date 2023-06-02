<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\BookTranslation;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public static $itemsPerPage = 10;
    
    // see index() for comments     
    // this is **very bad programming**
    public function allActivity($page) {
        
        $itemsPerPage = HomeController::$itemsPerPage;
        
        $recentUniqueBookTests = [];
        $tests = \App\TestResult::where('user', '=', Auth::id())->orderBy('created_at', 'DESC')->get();
        
        $count = 0;
        
        $foundTests = [];
        
        // this kind of **really sucks**
        foreach($tests as $test) {
            
            if(!isset($foundTests[$test->book_translation])) {
                
                $foundTests[$test->book_translation] = $test;
                
                if(!($count < ($page * $itemsPerPage) - $itemsPerPage)) {
                    
                    array_push($recentUniqueBookTests, $test);
                    
                }
                
                $count++;
                
                if($count >= ($page * $itemsPerPage)) {
                    
                    break;
                    
                }
                
            }
            
        }
        
        $recentUniqueBookParagraphs = [];
        
        foreach($recentUniqueBookTests as $test) {
            
            array_push($recentUniqueBookParagraphs, \App\ParagraphTranslation::findOrFail($test->translation_paragraph));
            
        }
        
        $booksForParagraphs = [];
        $nextParagraphs = [];
        
        foreach($recentUniqueBookParagraphs as $para) {
            
            array_push($booksForParagraphs, $para->getTranslatedBook());
            array_push($nextParagraphs, $para->hasNextParagraph() ? $para->getNextParagraph() : $para); // just want to have to use one
            
        }
        
        
        return view('activity', compact('recentUniqueBookParagraphs', 'booksForParagraphs', 'nextParagraphs', 'recentUniqueBookTests', 'page'));
        
    }
    
    public static function allActivityHasNextPage($page) {
        
        return HomeController::allActivityHasPage($page + 1);
        
    }
    
    public static function allActivityHasPreviousPage($page) {
        
        return HomeController::allActivityHasPage($page - 1);
        
    }
    
    // this is **very bad programming**
    public static function allActivityHasPage($page) {
        
        $itemsPerPage = HomeController::$itemsPerPage;
        
        if($page < 1) {
            
            return false;
            
        }
        
        // copy paste job from index(), this should all be condensed into one method
        $recentUniqueBookTests = [];
        $tests = \App\TestResult::where('user', '=', Auth::id())->orderBy('created_at', 'DESC')->get();
        
        $count = 0;
        
        $foundTests = [];
        
        // this kind of **really sucks**
        foreach($tests as $test) {
            
            if(!isset($foundTests[$test->book_translation])) {
                
                $foundTests[$test->book_translation] = $test;
                
                if(!($count < ($page * $itemsPerPage) - $itemsPerPage)) {
                    
                    array_push($recentUniqueBookTests, $test);
                    
                }
                
                $count++;
                
                if($count >= ($page * $itemsPerPage)) {
                    
                    break;
                    
                }
                
            }
            
        }
        
        if(count($recentUniqueBookTests) <= 0) {
            
            return false;
            
        }
        
        return true;
        
    }
    

    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // this is **very bad programming**
    public function index()
    {
        
        $recentUniqueBookTests = [];
        
        // I just stopped caring. I'm unsure if the query builder can handle a query like this without just using a raw query 
        // It's funny to me that this is allowed, but a group by isn't allowed... This definitely needs to be optimized. Even with
        // indexes, it's just pulling soo much data. (though, we do a similar thing below... so...) This entire page needs to be optimized
        // o(2*nlogn) + o(n) = o(nlogn)
        $tests = \App\TestResult::where('user', '=', Auth::id())->orderBy('created_at', 'DESC')->get();
        
        $count = 0;

        $foundTests = [];
        
        
        // let's pretend the above is indexed, then there it's literally just a where = auth::id, 
        // which is 2 binary searches for the beginning and the end o(logn) 
      
        // so... we load 20,000 records into memory from the disk. (that's why it's garbage)
        // then, here, it could be possible to binary search each separate record. o(logn * 5)
        
        // but right now, it's just o(n) 
        
        // Indexing is a bad idea here... Insertions would be expensive when this can all be done 
        // in nearly constant time if records were just kept on the progress that someone is making
        // within a book. Whenever the below stats are updated to something more intelligent, this probably
        // should be done too. Though, **indexing seems like a bad idea now.**
        foreach($tests as $test) {
            
            if(!isset($foundTests[$test->book_translation])) {
                
                $foundTests[$test->book_translation] = $test;
                array_push($recentUniqueBookTests, $test);
                $count++;
                
                if($count >= 3) {
                    
                    break;
                    
                }
                
            }
           
        }
        
        $recentUniqueBookParagraphs = [];

        foreach($recentUniqueBookTests as $test) {
            
            array_push($recentUniqueBookParagraphs, \App\ParagraphTranslation::findOrFail($test->translation_paragraph));
            
        }
        
        $booksForParagraphs = [];
        $nextParagraphs = [];
        
        foreach($recentUniqueBookParagraphs as $para) {

            array_push($booksForParagraphs, $para->getTranslatedBook());
            array_push($nextParagraphs, $para->hasNextParagraph() ? $para->getNextParagraph() : $para); // just want to have to use one
            
        }
        
        // This is a really bad design. Instead, this data should be condensed every now and then so that
        // lookups are not nearly as expensive. It also probably isn't a very good idea to pass thousands of points
        // to a chart in this way, but it might work out.
        $scores = \App\TestResult::where('user', '=', Auth::id())->orderBy('created_at', 'ASC')->get();
        
        $averageWPM = 0;
        
        if(!isset($scores)) {
            
            $scores = [];
            $averageWPM = 0;
            
        } else {
            
            $averageWPM = number_format(\App\TestResult::where('user', '=', Auth::id())->avg('wpm'), 2);
            
        }
        
        $logoutButton = true;
        
        return view('profile', compact('scores', 'recentUniqueBookParagraphs', 'booksForParagraphs', 'nextParagraphs', 'averageWPM', 'logoutButton'));
    }
    
    public function updateEmail(Request $request) {
        
        
        $validatedData = $request->validate([
            'currentPassword' => ['required'],
            'newEmail' => ['required', 'email'],
            'newEmailConfirm' => ['required', 'email'],
        ]);
        
        $currentUser = \App\User::find(Auth::id());
        $hash = Hash::make($request->currentPassword);
        
        //https://stackoverflow.com/questions/34756064/understanding-password-verify/34756237#:~:text=The%20password_verify%20function%20grabs%20your,rounds%20from%20our%20old%20hash.
        /*
         * 
         *   $2a$10$4m/TjukW7De5OszVFYL9quIXNz5pSDc2P.jX5A138G493Vqr0vUiO
         *   $2a is the identifier saying that the hash is bcrypt
         *
         *    $10$ is telling us to hash with 10 rounds of bcrypt
         *
         *    4m/TjukW7De5OszVFYL9qu is the salt
         *
         *    IXNz5pSDc2P.jX5A138G493Vqr0vUiO this is the hashed value.
         * 
         */
        
        // either of the below should work fine
        //password_verify($hash, $currentUser->password) 
        //Hash::check($hash, $currentUser->password);
        
        // Hash::check literally just uses password_verify...
        
        if(password_verify($request->currentPassword, $currentUser->password)) {
            
            if($request->newEmail == $request->newEmailConfirm) {
                
                $currentUser->email = $request->newEmail;
                
                if($currentUser->save()) {
                    
                    return redirect()->back()->with('success', 'Your email has been updated!');
                    
                }
                
            } else {
                
                return redirect()->back()->with('danger', 'Emails do not match. Email was not changed.');
                
            }
            
       
        }
        
        return redirect()->back()->with('danger', 'Incorrect password. Email was not changed.');
        
    }
    
    
    public function toggleDarkMode(Request $request) {
        
        $user = \App\User::findOrFail(Auth::id());
        
        if($user->darkmode_on) {
            
            $user->darkmode_on = false;
            
        } else {
            
            $user->darkmode_on = true;
            
        }
        
        $user->save();
        
        return redirect()->back();
        
    }
    
    public function updatePassword(Request $request) {
        
        $validatedData = $request->validate([
            'currentPassword' => ['required'],
            'newPassword' => ['required', 'min:8'],
            'newPasswordConfirm' => ['required', 'min:8'],
        ]);
        
        $currentUser = \App\User::find(Auth::id());
        $hash = Hash::make($request->currentPassword);
        
        //https://stackoverflow.com/questions/34756064/understanding-password-verify/34756237#:~:text=The%20password_verify%20function%20grabs%20your,rounds%20from%20our%20old%20hash.
        /*
         *
         *   $2a$10$4m/TjukW7De5OszVFYL9quIXNz5pSDc2P.jX5A138G493Vqr0vUiO
         *   $2a is the identifier saying that the hash is bcrypt
         *
         *    $10$ is telling us to hash with 10 rounds of bcrypt
         *
         *    4m/TjukW7De5OszVFYL9qu is the salt
         *
         *    IXNz5pSDc2P.jX5A138G493Vqr0vUiO this is the hashed value.
         *
         */
        
        // either of the below should work fine
        //password_verify($hash, $currentUser->password)
        //Hash::check($hash, $currentUser->password);
        
        // Hash::check literally just uses password_verify...
        
        if(password_verify($request->currentPassword, $currentUser->password)) {
            
            if($request->newPassword == $request->newPasswordConfirm) {
                
                $currentUser->password = Hash::make($request->newPassword);
                
                if($currentUser->save()) {
                    
                    return redirect()->back()->with('success', 'Your password has been updated!');
                    
                }
                
            } else {
                
                return redirect()->back()->with('danger', 'Passwords do not match. Password was not changed.');
                
            }
            
            
        }
        
        return redirect()->back()->with('danger', 'Incorrect password. Password was not changed.');
        
    }
    
}
