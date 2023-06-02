<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParagraphTranslationController extends Controller
{
    
    // This should probably just be a static method, but I just kept the OO method
    // and created a static method that uses this method for everything else to use
    
    public function getParagraph($translatedBook, $paragraphNumber) {
        
        $translatedBook = \App\BookTranslation::findOrFail($translatedBook);
        $originalParagraph = \App\Paragraph::where('paragraph_count', '=', $paragraphNumber)->where('book', '=', $translatedBook->book)->first();
        
        if(!isset($originalParagraph)) {
            
            abort(404);
            
        }
        
        $translatedParagraph = \App\ParagraphTranslation::where('original_paragraph', '=', $originalParagraph->id)->where('translated_book', '=', $translatedBook->id)->first();
        $originalBook = \App\Book::findOrFail($translatedBook->book);
        
        if(!$originalBook->userHasAccess()) {
            
            return redirect()->back()->with('danger', __('no_access_error_message.error'));
            
        }
        
        if(!isset($translatedParagraph)) {
            
            abort(404);
            
        }
        
        $gameData = new \stdClass();
        $gameData->original_words = json_decode($originalParagraph->paragraph_words);
        $gameData->translated_words = json_decode($translatedParagraph->words);
        $gameData->original_sentences = json_decode($originalParagraph->paragraph_sentences);
        $gameData->translated_sentences = json_decode($translatedParagraph->sentences);
        $gameData->grammar = json_decode($translatedParagraph->grammar);
        $gameData->chapter = $originalParagraph->chapter;
        $gameData->part = $originalParagraph->part;
        $gameData->paragraph = $originalParagraph->paragraph;
        $gameData->paragraphNumberInBook = $originalParagraph->paragraph_count;
        $gameData->book_title = $originalBook->title;
        $gameData->author = $originalBook->author;
        $gameData->paragraphsInBook = $originalBook->amount_of_paragraphs;
        $gameData->translatedBook = $translatedBook->id;
        $gameData->native_language = $translatedBook->translation_language;
        $gameData->learning_language = $translatedBook->original_language;
        $gameData->base_api_address = url('/api/translation/book');
        $gameData->game_address = url('/game/' . $translatedBook->id . '/' . $gameData->paragraphNumberInBook);
        $gameData->serverGameTitle = $originalParagraph->getFormattedTitle();
        $gameData->punctuationArray = $originalBook->getPunctuationArray();
        
        if(Auth::check()) {
            
            $gameData->user = Auth::id();
            $gameData->csrf = csrf_token();
            
            
        }
        
        return json_encode($gameData, JSON_UNESCAPED_UNICODE);
    }
    
    
    public function saveScore($translatedBook, $paragraphNumber, Request $request) {
        
        $translatedBook = \App\BookTranslation::find($translatedBook);
        $originalParagraph = \App\Paragraph::where('paragraph_count', '=', $paragraphNumber)->where('book', '=', $translatedBook->book)->first();
        $translatedParagraph = \App\ParagraphTranslation::where('original_paragraph', '=', $originalParagraph->id)->where('translated_book', '=', $translatedBook->id)->first();

        $testResult = new \App\TestResult();
        
        $testResult->wpm = $request->score;
        $testResult->user = Auth::id();
        $testResult->paragraph = $originalParagraph->id;
        $testResult->translation_paragraph = $translatedParagraph->id;
        $testResult->book_translation = $translatedBook->id;
        $testResult->book = $translatedBook->getBook()->id;
        $testResult->language = $translatedBook->getBook()->getLanguage()->id;
        
        $testResult->save();
        
    }
    
    
    public static function getParagraphData($translatedBook, $paragraphNumber) {
        
        $c = new ParagraphTranslationController();
        
        return $c->getParagraph($translatedBook, $paragraphNumber);
        
    }
    
    
    
}
