<?php

namespace App\Http\Controllers;

use App\Book;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ImportController extends Controller
{
    public function index() {
        
        $languages = \App\Language::get();
        
        $books = Book::where('added_by', '=', Auth::id())->orderBy('created_at', 'DESC')->limit(3)->get();
        
        $baseAddress = ImportController::$baseAddressForUsersBooks;
        
        return view('import/index', compact('languages', 'books', 'baseAddress'));
        
    }
    
    public function guide() {
        
        return view('import/import_guide');
        
    }
    
    public static $defaultImportedBooksForUserAmount = 10;
    public static $baseAddressForUsersBooks = '/import/added';
    

    
    public function importedBooksForUser($page) {
        
        $amount = ImportController::$defaultImportedBooksForUserAmount;
        $baseAddress = ImportController::$baseAddressForUsersBooks;
        
        $books = Book::where('added_by', '=', Auth::id())->orderBy('created_at', 'DESC')->skip(($page - 1) * $amount)->take($amount)->get();
        
        return view('import/added_books_for_user', compact('books', 'baseAddress', 'page'));
        
    }
    
    public static function importedBooksForUserHasPage($page) {
        
        if($page < 1) {
            
            return false;
            
        }
        
        $amount = ImportController::$defaultImportedBooksForUserAmount;
        
        return count(Book::where('added_by', '=', Auth::id())->orderBy('created_at', 'DESC')->skip(($page - 1) * $amount)->take($amount)->get()) > 0;
        
    }
    
    public function saveBook(Request $request) {
        
        $validator = Validator::make($request->all(), [
            
            'title' => 'required|max:50|min:1',
            'author' => 'required|max:25|min:1',
            'language' => 'required|exists:App\Language,id',
            'book' => 'required|between:0,10000|mimes:txt',
                
        ]);
        
        if ($validator->fails()) {
            
            return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            
        }
        
        
        $path = $request->file('book')->store('books');
        
        $user = Auth::id();
        
        $isPrivate = false;
        
        if(isset($request->isPrivate)) {
            
            $isPrivate = (bool)$request->isPrivate;
            
        }
        
        if(\App\Book::createBook2($request->title, $request->author, $request->language, $path, $user, $isPrivate)) {
            
            return redirect()->back()->with('success', __('user_book_import.95'));
            
        }
        
        return redirect()->back()->with('error', __('user_book_import.96'));
        
    }
    
    public function reviewBook(Request $request, $bookId) {
        
        $book = \App\Book::findOrFail($bookId);
        
        if($book->added_by != Auth::id()) {
            
            return redirect()->back()->with('danger', 'You\'re not allowed here...');
            
        }
        
        $userReplacements = json_decode($book->replacements_user_defined);
        $bookErrors = $book->getCharactersNeedingReplacement();
        
        return view('import/review', compact('book', 'bookErrors', 'userReplacements'));
        
    }
    
    public function userActivateBook(Request $request, $bookId) {
        
        $book = \App\Book::findOrFail($bookId);
        
        if($book->added_by != Auth::id()) {
            
            return redirect()->back()->with('danger', 'You do not have permission over that book.');
            
        }
        
        $charsNeedingReplacement = $book->getCharactersNeedingReplacement();
        $replaceChars = [];
        
        $count = count($charsNeedingReplacement);
        
        for($i = 0; $i < $count; $i++) {
            
            if($request['replacement' . $i] == null) {
                
                return redirect()->back()->with('danger', __('user_book_import.97') . '"' . $charsNeedingReplacement[$i] . '".');
                

            } else {
                
                //exit($request['replacement' . $i]);
                
                $temp = html_entity_decode($request['replacement' . $i]);
                
                $punctuationMap = $book->getPunctuationMap();
                
                if(\App\StringTools::stringContainsPunctuation2($temp, $punctuationMap)) {
                    
                    throw new \Exception(__('user_book_import.98') .' "' . $temp . '" ' .   __('user_book_import.99') . ' "' . $charsNeedingReplacement[$i] . '". ' .   __('user_book_import.100') . '');
                    
                }
                
                if(str_contains($temp, " ") || str_contains($temp, "<") || str_contains($temp, ">")) {
                        
                    return redirect()->back()->with('danger', '' .   __('user_book_import.101') . ' "' . $temp . '" ' .   __('user_book_import.102') . ' "' . $charsNeedingReplacement[$i] . '". ' .   __('user_book_import.103') . '');
                 
                }
                    
                $replaceChars[$i] = $temp;
                
            }
            
        }
        
        if($book->state == 'validation') {
        
            $book->state = 'running_replacements';
            $book->replacements_user_defined = json_encode($replaceChars, JSON_UNESCAPED_UNICODE);
            
            if($book->save()) {
                
                \App\Jobs\UserValidateBook::dispatch($book, $replaceChars)->onQueue('default_long');
                
            } else {
                
                return redirect()->back()->with('danger', '' .   __('user_book_import.104') . '');
                
            }
        
        } else {
            
            return redirect()->back()->with('danger', '' .   __('user_book_import.105') . '');
            
        }
        
        return redirect()->back()->with('success', '' .   __('user_book_import.106') . '');
        
    }
    
}
