<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\FixMissingParagraphsInBookTranslation;
use App\BookIndex;
use App\BookTranslation;
use App\Language;
use App\Jobs\ReplaceTextInBook;

class BookTranslationController extends Controller
{
   
    public function order($translation_book_id) {
        
        $translationBook = \App\BookTranslation::findOrFail($translation_book_id);
        
        $book = \App\Book::find($translationBook->book);
        
        return view('order/order', compact('translationBook', 'book'));
            
    }
    
    public function adminViewAllNotTranslated() {
        
        $books = \App\BookTranslation::where('has_translation', '=', false)->get();
        
        return view('admin/order', compact('books'));
        
    }
    
    public function adminModifyAndCreateTranslations() {
        
        $books = \App\Book::get();
        
        for($i = 0; $i < count($books); $i++) {
            
            $books[$i] = BookTranslation::where('book', '=', $books[$i]->id)->orderBy('translation_language', 'ASC')->get();
            
            if(count($books[$i]) == 0) 
                $books[$i] = $books[$i-1];
            
        }
        
        $languages = Language::orderBy('language', 'ASC')->get();
        
        return view('admin/manage_book', compact('books', 'languages'));
        
    }
    
    public function replaceTextInBook(Request $request) {
        
        $isRegex = (bool)$request->isRegex;
        $replaceText = $request->replace;
        $replaceWith = $request->replaceWith;
        $book = \App\Book::findOrFail($request->bookId);
        
        if(strlen($replaceText) <= 0) {
            
            return redirect()->back()->with('danger', 'No text entered to replace.');
            
        }
        
        ReplaceTextInBook::dispatch($book, $replaceText, $replaceWith, $isRegex)->onQueue('default_long');
        
        return redirect()->back()->with('success', 'Replacing text in progress!');
    }
    
    public function viewBook(Request $request, $bookID) {
        
        return $this->viewChapters($bookID, null);
        
    }
    
    public function viewChapters($bookID, $parentSection) {
        
        $bookTranslation = \App\BookTranslation::findOrFail($bookID);
        $book = \App\Book::findOrFail($bookTranslation->book);
        
        
        if(!$book->userHasAccess()) {
            
            return redirect()->back()->with('danger', __('no_access_error_message.error'));
            
        }
        
        $section = BookIndex::find($parentSection);

        $sections = $book->getSectionsWithParent($parentSection);
        $tests = $book->getTestsWithParent($parentSection);
        
        $originalLanguage = \App\Language::findOrFail($bookTranslation->original_language);
        $translatedLanguage = \App\Language::findOrFail($bookTranslation->translation_language);
        
        return view('part_list_new', compact('bookTranslation', 'book', 'originalLanguage', 'translatedLanguage', 'sections', 'tests', 'section'));
        
    }
    
    public function manageBookErrors() {
        
        // Books with failing validation
        $books = \App\BookTranslation::where('validation_errors', '!=', 0)->where('has_translation', 1)->get();
        
        return view('admin/issues_with_books', compact('books'));
        
    }
    
    public function fixBook(Request $request) {
        
        $bookId = $request->translationId;
        
        $book = \App\BookTranslation::findOrFail($bookId);
        
        FixMissingParagraphsInBookTranslation::dispatch($book);
        
        return redirect()->back()->with('success', 'This book is having the missing paragraphs within it fixed');
        
    }
    
    
    
}
