<?php

namespace App\Http\Controllers;

use App\BookTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class LearningLandingController extends Controller
{
    
    public function learn(Request $request, $native, $learning) {
        
        
        LanguageController::handleLocale($request, $native);     
        
        $notLearningLanguage = false;
        
        if($native == $learning) {
            
            $notLearningLanguage = true;
            
        }
        
        $native_lang = \App\Language::where('abbreviation', '=', $native)->first();
        $learning_lang = \App\Language::where('abbreviation', '=', $learning)->first();
        
        
        if(!isset($native_lang) || !isset($learning_lang)) {
            
            abort(404);
            
        }
        
        $landing = \App\LearningLanding::where('learning_lang', '=', $learning_lang->id)->where('native_lang', '=', $native_lang->id)->first();     
        
        $translatedBooks = BookTranslation::getBooksForLanguage($landing->id, true, 10, 0);
        $notYetTranslatedBooks = BookTranslation::getBooksForLanguage($landing->id, false, 10, 0);
        $translatedBooksForUser = null;
        $notYetTranslatedBooksForUser = null;
        
        if(Auth::check()) {
            
            $translatedBooksForUser = BookTranslation::getBooksForLanguageWithUser($landing->id, true, 10, 0, Auth::id());
            $notYetTranslatedBooksForUser = BookTranslation::getBooksForLanguageWithUser($landing->id, false, 10, 0, Auth::id());
            
        }
        
        $isLanding = true;
        
        return view('landing/landing', compact('learning_lang', 'native_lang', 'landing', 'translatedBooks', 'notYetTranslatedBooks', 'notLearningLanguage', 'translatedBooksForUser', 'notYetTranslatedBooksForUser', 'isLanding'));
    }
    
    /*
     * The below 4 methods should probably be condensed into one method.
     */
    
    
    public function learn2(Request $request, $native, $learning, $page) {
        
        LanguageController::handleLocale($request, $native);
        
        $native_lang = \App\Language::where('abbreviation', '=', $native)->first();
        $learning_lang = \App\Language::where('abbreviation', '=', $learning)->first();
        
        if(!isset($native_lang) || !isset($learning_lang)) {
            
            abort(404);
            
        }
        
        $landing = \App\LearningLanding::where('learning_lang', '=', $learning_lang->id)->where('native_lang', '=', $native_lang->id)->first();
        
        $books = BookTranslation::getBooksForLanguage($landing->id, true, 15, ($page - 1));
        
        $next = BookTranslation::getBooksForLanguage($landing->id, true, 15, ($page));
        $prev = BookTranslation::getBooksForLanguage($landing->id, true, 15, ($page - 2));
        
        $hasNextPage = count($next) > 0;
        $hasPreviousPage = count($prev) > 0 && $page > 1;
        
        $baseAddress = '/l/' . $native . '/' . $learning . '/translated/';
        
        $isLanding = false;
        
        return view('landing/view_books', compact('learning_lang', 'native_lang', 'landing', 'books', 'page', 'hasNextPage', 'hasPreviousPage', 'baseAddress', 'isLanding'));
    }
    
    public function learn3(Request $request, $native, $learning, $page) {
        
        LanguageController::handleLocale($request, $native);
        
        $native_lang = \App\Language::where('abbreviation', '=', $native)->first();
        $learning_lang = \App\Language::where('abbreviation', '=', $learning)->first();
        
        if(!isset($native_lang) || !isset($learning_lang)) {
            
            abort(404);
            
        }
        
        $landing = \App\LearningLanding::where('learning_lang', '=', $learning_lang->id)->where('native_lang', '=', $native_lang->id)->first();
        
        $books = BookTranslation::getBooksForLanguage($landing->id, false, 15, ($page - 1));
        
        $next = BookTranslation::getBooksForLanguage($landing->id, false, 15, ($page));
        $prev = BookTranslation::getBooksForLanguage($landing->id, false, 15, ($page - 2));
        
        $hasNextPage = count($next) > 0;
        $hasPreviousPage = count($prev) > 0 && $page > 1;
        
        $baseAddress = '/l/' . $native . '/' . $learning . '/waiting/';
        
        $isLanding = false;
        
        return view('landing/view_books_not_translated', compact('learning_lang', 'native_lang', 'landing', 'books', 'page', 'hasNextPage', 'hasPreviousPage', 'baseAddress', 'isLanding'));
    }
    
    public function learn4(Request $request, $native, $learning, $page) {
        
        LanguageController::handleLocale($request, $native);
        
        $native_lang = \App\Language::where('abbreviation', '=', $native)->first();
        $learning_lang = \App\Language::where('abbreviation', '=', $learning)->first();
        
        if(!isset($native_lang) || !isset($learning_lang)) {
            
            abort(404);
            
        }
        
        $landing = \App\LearningLanding::where('learning_lang', '=', $learning_lang->id)->where('native_lang', '=', $native_lang->id)->first();
        
        $books = BookTranslation::getBooksForLanguageWithUser($landing->id, true, 15, ($page - 1), Auth::id());
        
        $next = BookTranslation::getBooksForLanguageWithUser($landing->id, true, 15, ($page), Auth::id());
        $prev = BookTranslation::getBooksForLanguageWithUser($landing->id, true, 15, ($page - 2), Auth::id());
        
        $hasNextPage = count($next) > 0;
        $hasPreviousPage = count($prev) > 0 && $page > 1;
        
        $baseAddress = '/l/' . $native . '/' . $learning . '/user/translated/';
        
        $isLanding = false;
        
        return view('landing/view_books', compact('learning_lang', 'native_lang', 'landing', 'books', 'page', 'hasNextPage', 'hasPreviousPage', 'baseAddress', 'isLanding'));
    }
    
    public function learn5(Request $request, $native, $learning, $page) {
        
        LanguageController::handleLocale($request, $native);
        
        $native_lang = \App\Language::where('abbreviation', '=', $native)->first();
        $learning_lang = \App\Language::where('abbreviation', '=', $learning)->first();
        
        if(!isset($native_lang) || !isset($learning_lang)) {
            
            abort(404);
            
        }
        
        $landing = \App\LearningLanding::where('learning_lang', '=', $learning_lang->id)->where('native_lang', '=', $native_lang->id)->first();
        
        $books = BookTranslation::getBooksForLanguageWithUser($landing->id, false, 15, ($page - 1), Auth::id());
        
        $next = BookTranslation::getBooksForLanguageWithUser($landing->id, false, 15, ($page), Auth::id());
        $prev = BookTranslation::getBooksForLanguageWithUser($landing->id, false, 15, ($page - 2), Auth::id());
        
        $hasNextPage = count($next) > 0;
        $hasPreviousPage = count($prev) > 0 && $page > 1;
        
        $baseAddress = '/l/' . $native . '/' . $learning . '/user/waiting/';
        
        $isLanding = false;
        
        return view('landing/view_books_not_translated', compact('learning_lang', 'native_lang', 'landing', 'books', 'page', 'hasNextPage', 'hasPreviousPage', 'baseAddress', 'isLanding'));
    }
    
    
    
}
