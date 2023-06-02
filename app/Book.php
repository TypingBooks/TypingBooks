<?php

namespace App;

use App\Jobs\ImportBook;
use App\Jobs\ImportBook2;
use App\Jobs\UpdateBookPricing;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Book extends Model
{
    
    public static function createBook($title, $author, $language, $bookPath) {

        $book = new \App\Book();
        $book->title = $title;
        $book->author = $author;
        $book->language = $language;
        $book->location = $bookPath;
        
        if($book->save()) {
            
            ImportBook::dispatch($book)->onQueue('default_long');
            
        } else {
            
            return false;
            
        }
        
        return true;
        
    }
    
    public function getSectionsWithParent($parentId) {
        
        $indices = \App\BookIndex::where('book', '=', $this->id)->where('parent', '=', $parentId)->orderBy('order', 'ASC')->get();
        
        return $indices;
        
    }
    
    public function getTestsWithParent($parentId) {
        
        $tests = \App\Paragraph::where('book', '=', $this->id)->where('parent_index', '=', $parentId)->orderBy('order_in_section', 'ASC')->get();
        
        return $tests;
        
    }
    
    public static function createBook2($title, $author, $language, $bookPath, $userId, $isPrivate) {
        
        $book = new \App\Book();
        $book->title = $title;
        $book->author = $author;
        $book->language = $language;
        $book->location = $bookPath;
        $book->added_by = $userId;
        $book->is_private = $isPrivate;
        
        if($book->save()) {
            
            ImportBook2::dispatch($book)->onQueue('default_long');
            
        } else {
            
            return false;
            
        }
        
        return true;
        
    }
    
    public function isPrivate() {
        
        return $this->is_private;
        
    }
    
    public function getTextState() {
        
        $state = __('user_book_import.107');
        
        switch($this->getState()) {
            
            case 'error': 
                $state = $state;
                break;
            case 'importing':
                $state = __('user_book_import.108');
                break;
            case 'validation':
                $state = __('user_book_import.109');
                break;
            case 'live':
                $state = __('user_book_import.110');
                break;
            case 'running_replacements':
                $state = __('user_book_import.111');
                break;
        }
        
        return $state;
        
    }
    
    public function getAddedBy() {
        
        return User::find($this->added_by);
        
    }
    
    public function isActive() {
        
        return $this->is_active;
        
    }
    
    public function getIndex() {
        
        return \App\BookIndex::where('book', '=', $this->id)->get();
        
    }
    
    public function deactivate() {
        
        $thisBook = $this;
        
        try { 
        
            DB::transaction(function() use ($thisBook) {
                
                $thisBook->is_active = false;
                
                $translations = BookTranslation::where('book', '=', $thisBook->id)->get();
                
                $allDeactivated = true;
                
                foreach($translations as $translation) {
                    
                    $allDeactivated = $translation->deactivate() && allDeactivated;
                    
                }
                
                if(!$thisBook->save() || !$allDeactivated) {
                    
                    throw new \Exception("Failed to deactivate.");
                    
                }
                
            });
        
        } catch(\Exception $e) {
            
            return false;
            
        }
        
        return true;
        
    }
    
    public function userHasAccess() {
        
        if($this->isPrivate()) {
            
            if(Auth::check()) {
                
                if($this->getAddedBy()->id == Auth::id()) {
                    
                    return true;
                    
                }
                
            }
            
            return false;
            
        }
        
        return true;
        
    }
    
    public function getUserWPMInBook($userId) {
        
        return number_format(\App\TestResult::where('book', '=', $this->id)->where('user', '=', $userId)->avg('WPM'), 2);
        
    }
    
    public function getBookAddress(Request $request) {
        
        $sessionLocale = $request->session()->get('locale');
        
        $language = Language::where('abbreviation', '=', $sessionLocale)->first();
        
        if(!isset($language)) {
            
            $language = $this->getLanguage();
            
        }
        
        $translation = BookTranslation::where('translation_language', '=', $language->id)->where('book', '=', $this->id)->first();
        
        if(!$translation->hasTranslation()) {
            
            $translation = BookTranslation::where('translation_language', '=', $this->getLanguage()->id)->where('book', '=', $this->id)->first();
            
        }
        
        return $translation->getBookAddress();
        
    }
    
    public function activate() {
        
        $thisBook = $this;
        
        try {
            
            DB::transaction(function() use ($thisBook) {
                
                $thisBook->is_active = true;
                
                $translations = BookTranslation::where('book', '=', $thisBook->id)->get();
                
                $allActivated = true;
                
                foreach($translations as $translation) {
                    
                    $allActivated = $translation->activate() && $allActivated;
                    
                }
                
                if(!$thisBook->save() || !$allActivated) {
                    
                    throw new \Exception("Failed to activate.");
                    
                }
                
            });
                
        } catch(\Exception $e) {
            
            return false;
            
        }
        
        return true;
        
    }
    
    public function createBaseTranslationBook(Language $language, LearningLanding $landing) {
        
        $translation = new \App\BookTranslation();
        
        $translation->book = $this->id;
        $translation->translation_language = $language->id;
        $translation->learning_landing = $landing->id;
        $translation->has_translation = false;
        $translation->original_language = $this->language;
        $translation->characters_not_in_dictionary = $this->characters_in_words;
        
        if(!$translation->save()) {
            
            return false;
            
        }
        
        return true;
        
    }
    
    public function getAmountOfParts() {
        
        $parts = \App\Paragraph::where('book', '=', $this->id)->distinct()->count('part');
        
        return $parts;
        
    }
    
    public function getLanguage() {
        
        return \App\Language::find($this->language);
        
    }
    
    public function getAmountOfChaptersInPart($part) {
        
        $chapters = \App\Paragraph::where('book', '=', $this->id)->where('part', '=', $part)->distinct()->count('chapter');
        
        return $chapters;
        
    }
    
    public function getAmountOfParagraphsInChapter($part, $chapter) {
        
        $paragraphCount = \App\Paragraph::where('book', '=', $this->id)->where('part', '=', $part)->where('chapter', '=', $chapter)->distinct()->count('paragraph');
        
        return $paragraphCount;
        
    }
    
    public function getParagraphsInChapter($part, $chapter) {
        
        $paragraphs = \App\Paragraph::where('book', '=', $this->id)->where('part', '=', $part)->where('chapter', '=', $chapter)->orderBy('paragraph_count', 'ASC')->get();
        
        return $paragraphs;
        
    }
    
    // Returns all words in the book with punctuation removed
    public function getAllWordsInBook() {
        
        $book = str_replace("\n", ' ',Storage::get($this->location));
        $book = str_replace("\r", '', $book);
        
        $book = htmlspecialchars_decode($book);
        $book = StringTools::convertToUTF8($book);
        
        $wordsInBook =  explode(' ', $book); // faster to just do this than json_decode a bunch of times
        
        // Note: Below removes @ and ^ symbols. 
        for($i = 0; $i < count($wordsInBook); $i++) {
            
            $wordsInBook[$i] = mb_strtolower(\App\StringTools::removeNonWordCharacters($wordsInBook[$i]), 'UTF-8');
            
        }
        
        return $wordsInBook;
        
    }
    
    public function getTitle() {
        
        return $this->title;
        
    }
    
    public function calculateAmountOfCharactersInBook() {
        
        // storage is used because it should be faster than querying the db.
        $bookText = Storage::get($this->location);
        
        $bookText = htmlspecialchars_decode($bookText);
        $bookText = StringTools::convertToUTF8($bookText);
        
        // New lines are not sent to our translation provider
        $bookText = str_replace("\n", '', $bookText);
        $bookText = str_replace("\r", '', $bookText);
        
        // Characters below are used in handling chapters/parts of the book,
        // they are also not sent to the translation provider.
        $bookText = str_replace('@', '', $bookText);
        $bookText = str_replace('^', '', $bookText);
        
        return mb_strlen($bookText, 'UTF-8');
        
    }
    
    public function updateAmountOfCharactersInBook() {
        
        $this->characters = $this->calculateAmountOfCharactersInBook();
        
        return $this->save();
        
    }
    
    public function getDiscordMessage() {
        
        $msg = 'A new book has just been added! 

' .    '**Title**: ' . $this->getTitle() . '
' .    '**Author**: ' . $this->getAuthor() . '
' .    '**Language**: ' . $this->getLanguage()->language;
        
        
        return $msg;
        
    }
    
    public function getAuthor() { 
        
        return $this->author;
        
    }
    
    public function calculateAmountOfCharactersInWordsInBook() {
        
        $count = 0;
           
        $words = $this->getAllWordsInBook();
        
        foreach($words as $word) {
            
            if(empty($word))
                continue;
            
            $count += mb_strlen($word, 'UTF-8');
            
        }
       
        return $count;
        
    }
    
    public function updateAmountOfCharactersFoundInWords() {
        
        $this->characters_in_words = $this->calculateAmountOfCharactersInWordsInBook();
        
        return $this->save();
        
    }
    
    public function getWhitelist() {
        
        return $this->getLanguage()->getWhitelist();
        
    }
    
    public function getReplaceList() {
        
        return $this->getLanguage()->getReplaceList();
        
    }
    
    public function getReplaceListArray() {
        
        return $this->getLanguage()->getReplaceListArray();
        
    }
    
    // Replaces text in the book. This is not a thread safe method, but that's somewhat intentional.
    // There's just too many replacements that need to happen within a transaction that waiting on locks
    // could be very problematic.
    public function replaceInBook($replace, $replaceWith, $isRegex, $punctuationMap) {
        
        $book = $this;
        
        DB::transaction(function() use ($book, $replace, $replaceWith, $isRegex, $punctuationMap) {
            
            $paragraphs = Paragraph::where('book', '=', $book->id)->get();
            
            foreach($paragraphs as $paragraph) {
                
                $paragraph->paragraph_words = json_decode($paragraph->paragraph_words);
                $paragraph->paragraph_sentences = json_decode($paragraph->paragraph_sentences);
                
                if($isRegex) {
                    
                    $paragraph->paragraph_content = preg_replace($replace, $replaceWith, $paragraph->paragraph_content);
                    $paragraph->paragraph_words = preg_replace($replace, $replaceWith, $paragraph->paragraph_words); // it handles arrays fine
                    $paragraph->paragraph_sentences = preg_replace($replace, $replaceWith, $paragraph->paragraph_sentences);
                    
                } else {
                    
                    $paragraph->paragraph_content = str_replace($replace, $replaceWith, $paragraph->paragraph_content);
                    $paragraph->paragraph_words = str_replace($replace, $replaceWith, $paragraph->paragraph_words);
                    $paragraph->paragraph_sentences = str_replace($replace, $replaceWith, $paragraph->paragraph_sentences);
                    
                }
                
                $paragraph->paragraph_words = json_encode($paragraph->paragraph_words, JSON_UNESCAPED_UNICODE);
                $paragraph->paragraph_sentences = json_encode($paragraph->paragraph_sentences, JSON_UNESCAPED_UNICODE);
                
                for($i = 0; $i < 3 && !$paragraph->save(); $i++) {
                    
                    if($i == 2) {
                        
                        throw new \Exception('Failed to save a paragraph');
                        
                    }
                    
                }
                
                // Replacing punctuation can cause translations to become broken in alignment. 
                // Instead, it will recommend users to reimport the book instead. If this is triggered by an admin, it will break a book.
                /*
                if(!$paragraph->buildSentences2($punctuationMap)) {
                    
                    throw new \Exception('Failed to save the sentences');
                    
                }*/
                
            }
            
        });
        
        return true;
        
    }
    
    public function getCharactersNeedingReplacement() {
        
        return json_decode($this->characters_needing_replacement);
        
    }
    
    public function getTopLevelIndices() {
    
        $indices = \App\BookIndex::where('book', '=', $this->id)->where('parent', '=', null)->orderBy('order', 'ASC')->get();
        
        return $indices;   
        
    }
    
    public function hasIndex() {
        
        return count($this->getTopLevelIndices()) > 0;
        
    }
    
    public function getHTMLIndices() {
        
        $html = '<ol class="font-weight-bold">';
        
        $indices = $this->getTopLevelIndices();
        
        foreach($indices as $index) {
            
            $html = $html . $index->getHTMLChildren();     
            
        }
       
        $html = $html . '</ol>';
        
        return $html;
        
    }
    
    public function useWhitelist() {
        
        return $this->getLanguage()->useWhitelist();
        
    }
    
    public function getPunctuationList() {
        
        return $this->getLanguage()->getPunctuationList();
        
    }
    
    public function getState() {
        
        return $this->state;
        
    }
    
    public function getPunctuationArray() {
        
        $punctuationList = $this->getPunctuationList();
        
        $chars = StringTools::createUTF8CharacterArrayFromString($punctuationList);
        
        return $chars;
        
    }
    
    public function getPunctuationMap() {
        
        $punctuationList = $this->getPunctuationList();
        
        $punctuationMap = [];
        
        $chars = StringTools::createUTF8CharacterArrayFromString($punctuationList);
        
        foreach($chars as $char) {
            
            $punctuationMap[$char] = true;
            
        }
        
        return $punctuationMap;
        
    }
    
    public function fillDatabaseWithContents2() {
        
        $book = $this;
        $bookContents = Storage::get($this->location);
        
        DB::transaction(function () use ($bookContents, $book) {
            
            // create a hashmap with the punctuation marks for this language/gloabally
            $punctuationList = $book->getPunctuationList();
            
            $punctuationMap = [];
            
            $chars = StringTools::createUTF8CharacterArrayFromString($punctuationList);
            
            foreach($chars as $char) {
                
                $punctuationMap[$char] = true;
                
            }
            
            $indexLevel = 0;
             
            // don't want these to accidentally show up in tests
            $bookContents = htmlspecialchars_decode($bookContents);
            
            // in case someone tries to add a book that isn't in UTF-8
            $bookContents = StringTools::convertToUTF8($bookContents);
            
            // replaces the contents of this book with characters that were set for the language and globally
            $bookContents = StringTools::useReplaceArrayOnText($bookContents, $book->getReplaceListArray());
            
            // idk why I didn't just use regex.
            $bookContents = StringTools::replaceUntilNoMatch($bookContents, "  ", " "); // replace all repeating spaces with one space
            
            // windows - \r\n
            // linux = - \n
            // so the book can be parsed by just removing these symbols
            $bookContents = StringTools::replaceUntilNoMatch($bookContents, "\r", ""); 
            
            // remove lines with no content
            $bookContents = StringTools::replaceUntilNoMatch($bookContents, "\n \n", "\n"); 
            $bookContents = StringTools::replaceUntilNoMatch($bookContents, "\n\n", "\n");
            
            // html characters
            $bookContents = StringTools::replaceUntilNoMatch($bookContents, '<', '');
            $bookContents = StringTools::replaceUntilNoMatch($bookContents, '>', '');
            
            $bookContents = StringTools::replaceUntilNoMatch($bookContents, '|', '');
            
            // it doesn't actually matter if it's split with \n or not.
            $bookContents = StringTools::replaceUntilNoMatch($bookContents, "\n", "|");
            
            // it's a good idea to remove spaces at the beginning of tests...
            $bookContents = StringTools::replaceUntilNoMatch($bookContents, '| ', '|');
            
            // ...and at the end.
            $bookContents = StringTools::replaceUntilNoMatch($bookContents, ' |', '|');
            
            $charactersNotInWhitelist = [];
            
            if($this->useWhitelist()) {
                
                $charactersNotInWhitelist = StringTools::findCharactersNotInWhitelist($bookContents, $book->getWhitelist());
                
            }
            
            $book->characters_needing_replacement = json_encode($charactersNotInWhitelist, JSON_UNESCAPED_UNICODE);
            
            if(!$book->save()) {
                
                throw new \Exception('Failed to save book.');
                
            }
            
           
            // split into "paragraphs/tests"
            $bookContents = explode('|', $bookContents);
            
            $testsInBook = 1;
            $lastIndex = null;
            
            $lastIndexAtLevel = [];
            $amountOfChildrenAtLevel = [];
            
            $testGroups = 0;
            
            $orderInSection = 0;
            
            foreach($bookContents as $test) {
                
                if(str_starts_with($test, '=')) {
                    
                    $level = 0;
                    
                    while($level < strlen($test) && $test[$level] == '=') {
                        
                        $level++;
                        
                    }
                    
                    // we are going to assume that our users will not always have the correct levels..
                   
                    // if they move down multiple levels without first defining the levels before that, 
                    // it will fall back to the last defined level.
                    
                    while($level > 0 && !isset($lastIndexAtLevel[$level - 1])) {
                        
                        $level--;
                        
                    }
                    
                    // remove the ='s at the start
                    $test = str_replace('=', '', $test);
                    
                    // removes spaces at the start of the title
                    while(str_starts_with($test, ' ')) {
                        
                        $test = substr($test, 1);
                        
                    }
                    
                    // if the user just put an = but no title, its title is undefined
                    if(strlen($test) == 0) {
                        
                        $test = 'Undefined';
                        
                    }
                    
                    $currentIndex = new \App\BookIndex();
                    $orderInSection = 0;
                    
                    $currentIndex->title = $test;
                    
                    // title too long
                    if(strlen($test) >= 100) {
                        
                        $currentIndex->title = substr($test, 0, 99);
                        
                    }
                        
                    $currentIndex->book = $book->id;
                    
                    if($currentIndex->save()) {
                        
                        // below determines the parent index and the order in relation to the parent
                        $lastIndex = $currentIndex->id;
                        
                        if($level != 0) {
                            
                            $currentIndex->order = $amountOfChildrenAtLevel[$level - 1];
                            $amountOfChildrenAtLevel[$level-1]++;
                            $currentIndex->parent = $lastIndexAtLevel[$level - 1];
                            $lastIndexAtLevel[$level] = $currentIndex->id;
                            $amountOfChildrenAtLevel[$level] = 0;
                            
                        } else {
                            
                            $lastIndexAtLevel[1] = $currentIndex->id;
                            
                            if(!isset($amountOfChildrenAtLevel[0])) {
                                
                                $currentIndex->order = 0;
                                $amountOfChildrenAtLevel[0] = 1;
                                $amountOfChildrenAtLevel[1] = 0;
                                
                            } else {
                                
                                $currentIndex->order = $amountOfChildrenAtLevel[0];
                                $amountOfChildrenAtLevel[0]++;
                                $amountOfChildrenAtLevel[1] = 0;
                                
                            }
                            
                          
                            
                        }
                        
                        if(!$currentIndex->save()) {
                            
                            throw new \Exception('failed to save index after setting parent');
                            
                        }
                        
                        
                    } else {
                        
                        throw new \Exception('failed to save index');
                        
                    }
                
                    
                // index is known/actual importing of book
                } else {
                    
                    $paragraphLength = strlen($test);
                    
                    if($paragraphLength > 0) {
                        
                        $sentencesInTestGroup = Paragraph::buildSentencesWithText($test, $punctuationMap);
                        
                        $orderInTestGroup = 0;
                        $testGroup = $testGroups;
                        
                        $currentTest = '';
                        
                        // This is just a mess... The purpose is basically to just keep sentences in tests together.
                        // If a test is larger than 1200 (about 3 game tests), it splits it into another test in the db.
                        // This is done so that scores can be saved for the same content without users have to take extremely 
                        // long tests. It does allow users to have tests much longer than 1200 (up to 25000) if the sentence 
                        // isn't ending... However, if it's over that it throws an error and refuses to import the book. 
                        foreach($sentencesInTestGroup as $sentence) {
                            
                            // part of a new test
                            if(mb_strlen($currentTest, 'UTF-8') == 0) {
                                
                                
                                // sentence is larger than what is acceptable for a test
                                if(mb_strlen($sentence, 'UTF-8') > Paragraph::$LARGEST_TEST_SIZE) {
                                    
                                    if(mb_strlen($sentence, 'UTF-8') > 25000) {
                                        
                                        throw new \Exception('someone is trying to mess stuff up');
                                        
                                    }
                                    
                                    if(Book::createParagraphWithText($sentence, $book->id, $testGroup, $orderInTestGroup, $testsInBook, $lastIndex, $punctuationMap, $orderInSection)) {
                                        
                                        $orderInSection++;
                                        $testsInBook++;
                                        $orderInTestGroup++;
                                        
                                    } else {
                                        
                                        throw new \Exception('failed to create a paragraph');
                                        
                                    }
                                    
                                    
                                } else {
                                    
                                    $currentTest = $sentence;
                                    
                                }
                                
                                
                            } else {
                                
                                
                                // current test will be above what is acceptable
                                if(mb_strlen($currentTest . ' ' . $sentence, 'UTF-8') > Paragraph::$LARGEST_TEST_SIZE) {
                                   
                                    
                                    if(mb_strlen($currentTest, 'UTF-8') > 25000) {
                                        
                                        throw new \Exception('someone is trying to mess stuff up');
                                        
                                    }
                                    
                                    if(Book::createParagraphWithText($currentTest, $book->id, $testGroup, $orderInTestGroup, $testsInBook, $lastIndex, $punctuationMap, $orderInSection)) {

                                        $orderInSection++;
                                        $testsInBook++;
                                        $orderInTestGroup++;
                                        
                                        $currentTest = $sentence;
                                        
                                    } else {
                                        
                                        throw new \Exception('failed to create a paragraph');
                                        
                                    }
                                    
                                    
                                 // current test is an acceptable size
                                } else {
                                    
                                    $currentTest = $currentTest . ' ' . $sentence;
                                    
                                }
                                
                            }            
                            

                            
                        }
                        
                        // we added all other sentences, need to add this one now.
                        if(mb_strlen($currentTest, 'UTF-8') > 0) {
                            
                            if(mb_strlen($currentTest, 'UTF-8') > 25000) {
                                
                                throw new \Exception('someone is trying to mess stuff up');
                                
                            }
                            
                            if(Book::createParagraphWithText($currentTest, $book->id, $testGroup, $orderInTestGroup, $testsInBook, $lastIndex, $punctuationMap, $orderInSection)) {

                                $orderInSection++;
                                $testsInBook++;
                                $orderInTestGroup++;
                                
                                $currentTest = $sentence;
                                
                            } else {
                                
                                throw new \Exception('failed to create a paragraph');
                                
                            }
                            
                        }
                        
                        
                        $testGroups++;
                        
                    }
                    
                    
                    
                }
                
            }
            
            
        });
        
        return true;
        
    }
    
    public static function createParagraphWithText($text, $bookId, $testGroup, $orderInGroup, $orderInBook, $parentIndex, $punctuationMap, $orderInSection) {
        
        $dbParagraph = new \App\Paragraph();
        
        $dbParagraph->paragraph_content = $text;
        $dbParagraph->paragraph_words = json_encode(explode(' ', $text), JSON_UNESCAPED_UNICODE);
        $dbParagraph->book = $bookId;
        $dbParagraph->part = 0;
        $dbParagraph->chapter = 0;
        $dbParagraph->paragraph = 0;
        
        $dbParagraph->paragraph_count = $orderInBook;
        $dbParagraph->parent_index = $parentIndex;
        $dbParagraph->order_in_test_group = $orderInGroup;
        $dbParagraph->test_group = $testGroup;
        $dbParagraph->order_in_section = $orderInSection;
        
        if(!$dbParagraph->save()) {
            
            throw new \Exception('A paragraph failed to be added..');
            
        }
        
        if(!$dbParagraph->buildSentences2($punctuationMap)) {
            
            throw new \Exception('Failed to save the sentences');
            
        }
        
        return true;
        
    }
    
    
    public function fillDatabaseWithContents() {
        
        $book = Storage::get($this->location);
        
        DB::transaction(function () use ($book) {

            $part = 0;
            $chapter = 1;
            $paragraph = 1;
            $currentString = '';
            $paragraphCount = 1;
            
            if($book[0] != '@') {
                exit('bad format');
            }
            
            for($i = 0; $i < strlen($book); $i++) {
                
                // Need paragraphs - paragraph_content, book, part, chapter, paragraph
                // The translations are not handled here, this is just the solid book data.
                
                if($book[$i] != "\n") {
                    
                    if($book[$i] == '@' && $book[$i+1] == "\n") {
                        
                        $part++;
                        $chapter = 1;
                        $paragraph = 1;
                        
                        
                    } else if($book[$i] == '^'  && $book[$i+1] == "\n") {
                        
                        $chapter++;
                        $paragraph = 1;
                        
                    } else {
                        
                        $currentString = $currentString . $book[$i];
                        
                    }
                    
                } else {
                    
                    $paragraphLength = strlen($currentString);
                    
                    if($paragraphLength > 0) {
                       
                        $dbParagraph = new \App\Paragraph();
                        
                        $dbParagraph->paragraph_content = $currentString;
                        $dbParagraph->paragraph_words = json_encode(explode(' ', $currentString), JSON_UNESCAPED_UNICODE);
                        $dbParagraph->book = $this->id;
                        $dbParagraph->part = $part;
                        $dbParagraph->chapter = $chapter;
                        $dbParagraph->paragraph = $paragraph;
                        $dbParagraph->paragraph_count = $paragraphCount;
                        
                        if(!$dbParagraph->save()) {
                            
                            throw new \Exception('A paragraph failed to be added..');
                            
                        }
                        
                        if(!$dbParagraph->buildSentences()) {
                            
                            throw new \Exception('Failed to save the sentences');
                            
                        }
                        
                        $paragraph++;
                        $paragraphCount++;
                            
                    }
                    
                    $currentString = '';
                    
                }
                
            }
            
            
        });
        
        
        return true;
            
        
    }
    
    
}
