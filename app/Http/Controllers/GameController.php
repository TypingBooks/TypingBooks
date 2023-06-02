<?php

namespace App\Http\Controllers;

use App\TestResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ParagraphTranslation;

class GameController extends Controller
{
    public function loadBookGame(Request $request, $translatedBook, $paragraph) {
        
        $gameData = ParagraphTranslationController::getParagraphData($translatedBook, $paragraph);
        $data = json_decode($gameData);
        
        $translatedBook = \App\BookTranslation::findOrFail($translatedBook);
        $book = \App\Book::findOrFail($translatedBook->book);
        
        if(!$book->userHasAccess()) {
            
            return redirect()->back()->with('danger', __('no_access_error_message.error'));
            
        }
        
        if(!isset($gameData) || !isset($data)) {
            
            abort(404);
            
        }
        
        $notLearningLanguage = false;
        
        if($translatedBook->translation_language == $book->language) {
            
            $notLearningLanguage = true;
            
        }
        
        // Profile links here that should be causing the locale to change.
        LanguageController::handleLocale($request, $translatedBook->getLanguage()->abbreviation);
        
        return view('game', compact('gameData', 'data', 'notLearningLanguage'));
                
    }
    
    public function loadCurrentGame(Request $request, $translatedBook) {
        
        $translatedBook = \App\BookTranslation::findOrFail($translatedBook);
        $paragraph = 1;
        
        if(Auth::check()) {
            
            $current = TestResult::where('book_translation', '=', $translatedBook->id)->orderBy('created_at', 'DESC')->where('user', '=', Auth::id())->first();
            
            if(isset($current)) {
                
                $temp = ParagraphTranslation::find($current->translation_paragraph)->paragraph_count;
                
                $paragraph = ParagraphTranslation::where('translated_book', '=', $translatedBook->id)->where('paragraph_count', '=', $temp + 1)->first();
                
                // If the user has completed this book, then $temp is the last paragraph in the book
                // otherwise, it's safe to use the next paragraph
                if(!isset($paragraph)) {
                    
                    $paragraph = $temp;
                    
                } else {
                    
                    $paragraph = $temp + 1;
                    
                }
                
            }
            
        }
        
        
        return $this->loadBookGame($request, $translatedBook->id, $paragraph);
        
    }
}
