<?php

namespace App\Http\Controllers;

use App\Book;
use App\Language;
use App\TestResult;
use App\User;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    
    public function viewUser(Request $request, $userId) {
        
        $user = User::findOrFail($userId);
        
        $languages = TestResult::where('test_results.user', '=', $user->id)->groupBy('test_results.language')->join('languages', 'test_results.language', '=', 'languages.id')->select('languages.*')->orderBy('languages.language')->get();
        
        $temp = TestResult::where('user', '=', $user->id)->orderBy('created_at', 'DESC')->first();
        $book = Book::findOrFail($temp->book);
        $language = Language::findOrFail($temp->language);
        
        $last100Tests = TestResult::where('user', '=', $user->id)->orderBy('created_at', 'DESC')->limit(100)->get()->reverse();
        $last100TestsAverage = $this->average($last100Tests);//number_format(TestResult::where('user', '=', $user->id)->orderBy('created_at', 'DESC')->limit(100)->avg('wpm'), 2);
        
        $lastBookTests = TestResult::where('user', '=', $user->id)->where('book', '=', $book->id)->orderBy('created_at', 'ASC')->get();
        $lastBookTestsAverage = number_format(TestResult::where('user', '=', $user->id)->where('book', '=', $book->id)->orderBy('created_at', 'ASC')->avg('wpm'), 2);
        
        $lastLanguageTests = TestResult::where('user', '=', $user->id)->where('language', '=', $language->id)->orderBy('created_at', 'ASC')->get();
        $lastLanguageTestsAverage = number_format(TestResult::where('user', '=', $user->id)->where('language', '=', $language->id)->orderBy('created_at', 'ASC')->avg('wpm'), 2);
        
        return view('/stats/index', compact('last100Tests', 'lastBookTests', 'lastLanguageTests', 'last100TestsAverage', 'lastBookTestsAverage', 'lastLanguageTestsAverage', 'book', 'language', 'user', 'request', 'languages'));
    }
    
    public function viewLanguageForUser(Request $request, $userId, $languageId) {
        
        $user = User::findOrFail($userId);
        $language = Language::findOrFail($languageId);
        
        $temp = TestResult::where('user', '=', $user->id)->where('language', '=', $language->id)->orderBy('created_at', 'DESC')->first();
        $book = Book::findOrFail($temp->book);
        
        $last100Tests = TestResult::where('user', '=', $user->id)->where('language', '=', $language->id)->orderBy('created_at', 'DESC')->limit(100)->get()->reverse();
        $last100TestsAverage = $this->average($last100Tests);//number_format(TestResult::where('user', '=', $user->id)->where('language', '=', $language->id)->orderBy('created_at', 'DESC')->limit(100)->avg('wpm'), 2);
        
        $lastBookTests = TestResult::where('user', '=', $user->id)->where('language', '=', $language->id)->where('book', '=', $book->id)->orderBy('created_at', 'ASC')->get();
        $lastBookTestsAverage = number_format(TestResult::where('user', '=', $user->id)->where('language', '=', $language->id)->where('book', '=', $book->id)->orderBy('created_at', 'ASC')->avg('wpm'), 2);
        
        $lastLanguageTests = TestResult::where('user', '=', $user->id)->where('language', '=', $language->id)->orderBy('created_at', 'ASC')->get();
        $lastLanguageTestsAverage = number_format(TestResult::where('user', '=', $user->id)->where('language', '=', $language->id)->orderBy('created_at', 'ASC')->avg('wpm'), 2);
        
        return view('/stats/language', compact('request', 'last100Tests', 'lastLanguageTests', 'lastLanguageTestsAverage', 'book', 'language', 'last100TestsAverage',  'lastBookTests', 'lastBookTestsAverage', 'user'));
        
    }
    
    public function viewLanguagesForUser($userId) {
        
        $user = User::findOrFail($userId);
        
        $languages = TestResult::where('test_results.user', '=', $user->id)->groupBy('test_results.language')->join('languages', 'test_results.language', '=', 'languages.id')->select('languages.*')->orderBy('languages.language')->get();
        
        return view('/stats/languages', compact('languages', 'user'));
    }
    
    public function viewBooksForUser(Request $request, $userId) {
        
        $user = User::findOrFail($userId);
        
        $books = TestResult::where('test_results.user', '=', $user->id)->groupBy('test_results.book')->join('books', 'test_results.book', '=', 'books.id')->select('books.*')->orderBy('books.language')->orderBy('books.title')->get();
        
        return view('/stats/books', compact('books', 'user', 'request'));
    }
    
    public function viewBookForUser(Request $request, $userId, $bookId) {
        
        $user = User::findOrFail($userId);
        $book = Book::findOrFail($bookId);
        
        $language = $book->getLanguage();
        
        $last100Tests = TestResult::where('user', '=', $user->id)->where('book', '=', $book->id)->orderBy('created_at', 'DESC')->limit(100)->get()->reverse();
        $last100TestsAverage = $this->average($last100Tests);//number_format(TestResult::where('user', '=', $user->id)->where('language', '=', $language->id)->orderBy('created_at', 'DESC')->limit(100)->avg('wpm'), 2);
        
        $lastBookTests = TestResult::where('user', '=', $user->id)->where('book', '=', $book->id)->orderBy('created_at', 'ASC')->get();
        $lastBookTestsAverage = number_format(TestResult::where('user', '=', $user->id)->where('book', '=', $book->id)->orderBy('created_at', 'ASC')->avg('wpm'), 2);
        
        return view('/stats/book', compact('request', 'last100Tests',  'book',   'lastBookTests', 'lastBookTestsAverage','last100TestsAverage', 'user'));
        
    }
	
	public function average($records) {
		
		$total = 0;
		
		foreach($records as $record) {
			
			$total += $record->wpm;
			
		}
		
		if(count($records) > 0) {
			
			return number_format($total / count($records), 2);
			
		}
		
		return "0.00";
		
	}
    
    public function allBooksForUserInLanguage(Request $request, $userId, $languageId) {
        
        $user = User::findOrFail($userId);
        
        $books = TestResult::where('test_results.user', '=', $user->id)->where('test_results.language', '=', $languageId)->groupBy('test_results.book')->join('books', 'test_results.book', '=', 'books.id')->select('books.*')->orderBy('books.language')->orderBy('books.title')->get();
        
        return view('/stats/books', compact('books', 'user', 'request'));
        
    }
    
}
