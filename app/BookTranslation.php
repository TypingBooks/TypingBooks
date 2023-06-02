<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Jobs\TranslateParagraphForBook;

class BookTranslation extends Model
{
    
    public static function getNonValidatedBooks() {
        
        return BookTranslation::where('validation_errors', '!=', 0)->get();
        
    }
    
    // Returns the books found for a language. WithTranslation is a boolean for the books that
    // have a translation. true = books that have a translation. false - books that don't have a translation
    // Amount is the amount returned by
    // this method. Page is what page that you want from the (intended) paginated amount.
    public static function getBooksForLanguage($landingID, $withTranslation, $amount, $page) {
        
        $books = \App\BookTranslation::where('book_translations.learning_landing', '=', $landingID)
                                        ->where('book_translations.has_translation', '=', $withTranslation)
                                        ->where('book_translations.is_active', '=', 1)
                                        ->where('books.passed_validation_by_user', '=', 1)
                                        ->join('books', 'books.id', '=', 'book_translations.book')
                                        ->join('users', 'users.id', '=', 'books.added_by')
                                        ->select('book_translations.*', 'books.title', 'books.author', 'books.added_by', 'users.name')
                                        ->where('books.is_private', '=', 0)
                                        ->orderBy('books.title', 'ASC')
                                        ->skip(($page) * $amount)
                                        ->take($amount)
                                        ->get();
        return $books;
    }
    
    public static function getBooksForLanguageWithUser($landingID, $withTranslation, $amount, $page, $userId) {
        
        $books = \App\BookTranslation::where('book_translations.learning_landing', '=', $landingID)
        ->where('book_translations.has_translation', '=', $withTranslation)
        ->where('book_translations.is_active', '=', 1)
        ->where('books.added_by', '=', $userId)
        ->where('books.passed_validation_by_user', '=', 1)
        ->join('books', 'books.id', '=', 'book_translations.book')
        ->join('users', 'users.id', '=', 'books.added_by')
        ->select('book_translations.*', 'books.title', 'books.author', 'books.added_by', 'users.name')
        ->orderBy('books.title', 'ASC')
        ->skip(($page) * $amount)
        ->take($amount)
        ->get();
        
        return $books;
        
    }
    
    public function isValidated() {
        
        return $this->validation_errors == 0;
        
    }
    
    public function isActive() {
        
        return $this->is_active;
        
    }
    
    public function deactivate() {
        
        $this->is_active = false;
        
        return $this->save();
        
    }
    
    public function activate() {
        
        $this->is_active = true;
        
        return $this->save();
        
    }
    
    public function getValidationErrors() {
        
        return $this->validation_errors;
        
    }
    
    public function hasTranslation() {
        
        return $this->has_translation;
        
    }

    public function getAmountOfParts() {
        
        $book = \App\Book::findOrFail($this->book);
        
        return $book->getAmountOfParts();
        
    }
    
    public function getDiscordMessage() {
        
        // probably should find out how to do this correctly.
        // \r\n doesn't work.
        $msg = 'A new book translation is being added! 

' .    '**Title**: [' . $this->getTitle() . '](' . $this->getIndexAddress() . ') 
' .    '**Author**: '  . $this->getAuthor() . '
' .    '**Language**: ' . $this->getBook()->getLanguage()->language  . '
' .    '**Translation**: ' . $this->getLanguage()->language;
        
        return $msg;
        
    }
    
    public function getLanguage() {
            
        return \App\Language::findOrFail($this->translation_language);
        
    }
    
    public function getBookAddress() {
        
        return url('/book/' . $this->id);
        
    }
    
    public function getAddedBy() {
        
        return $this->getBook()->getAddedBy();
        
    }
    
    public function getBook() {
        
        return \App\Book::findOrFail($this->book);
        
    }
    
    public function getTitle() {
        
        return $this->getBook()->title;
        
    }
    
    public function getAuthor() {
        
        return $this->getBook()->author;
        
    }
    
    public function getAmountOfChaptersInPart($part) {
        
        $book = \App\Book::findOrFail($this->book);
        
        return $book->getAmountOfChaptersInPart($part);
        
    }
    
    // Updates the amount of errors in this translation.
    public function updateValidationState() {
        
        $paragraphsInBook = Paragraph::where('book', '=', $this->book)->orderBy('paragraph_count')->get();
        $paragraphsInTranslation = ParagraphTranslation::where('translated_book', '=', $this->id)->orderBy('paragraph_count', 'ASC')->get();
        
        $errors = 0;
        
        for($i = 0; $i + $errors < count($paragraphsInBook) && $i < count($paragraphsInTranslation); $i++) {
            
            while($paragraphsInBook[$i + $errors]->paragraph_count != $paragraphsInTranslation[$i]->paragraph_count ) {
                
                $errors++;
                
            }
            
        }
        
        $this->validation_errors = $errors;
        
        return $this->save();
        
    }
    
    // This function costs real money...
    public function fixMissingParagraphTranslations() {
        
        $paragraphsInBook = Paragraph::where('book', '=', $this->book)->orderBy('paragraph_count')->get();
        $paragraphsInTranslation = ParagraphTranslation::where('translated_book', '=', $this->id)->orderBy('paragraph_count', 'ASC')->get();
        
        $errors = 0;
        
        for($i = 0; $i + $errors < count($paragraphsInBook) && $i < count($paragraphsInTranslation); $i++) {
            
            while($paragraphsInBook[$i + $errors]->paragraph_count != $paragraphsInTranslation[$i]->paragraph_count ) {
                
                TranslateParagraphForBook::dispatch($paragraphsInBook[$i + $errors], $this->getBook(), $this, false);
                
                $errors++;
                
            }
            
        }
        
    }
    
    public function getAmountOfParagraphsInChapter($part, $chapter) {
        
        $book = \App\Book::findOrFail($this->book);
        
        return $book->getAmountOfParagraphsInChapter($part, $chapter);
        
    }
    
    public function getOriginalLanguage() {
        
        return \App\Language::findOrFail($this->original_language);
        
    }
    
    public function getParagraphsInChapter($part, $chapter) {
        
        $paragraphs = \App\ParagraphTranslation::where('translated_book', '=', $this->id)->where('part', '=', $part)->where('chapter', '=', $chapter)->orderBy('paragraph_count', 'ASC')->get();
        
        return $paragraphs;
        
    }
    
    public function getTranslationProgress() {
        
        if($this->translation_progress > 0) {
            
            return ($this->translation_progress / $this->getBook()->amount_of_paragraphs) * 100.0;
            
        }
        
        return 0.00;
        
    }
    
    public function getFormattedTranslationProgress() {
        
        return number_format($this->getTranslationProgress(), 2) . '%';
        
    }
    
    public function getIndexAddress() {
        
        return url('/book/' . $this->id);
        
    }
    
    // Creates a JSON file with the book sentences and their translations
    // This method only works if the book has been translated. Otherwise
    // it throws an exception
    public function buildAndCreateJSONFile() {
        
        $filePath = null;
        
        $object = new \stdClass();
        $object->title = $this->getTitle();
        $object->author = $this->getAuthor();
        $object->language = $this->getBook()->getLanguage()->language;
        $object->translation = $this->getLanguage()->language;
        $object->sectionData = [];
        $object->sentenceData = [];
        
        $bIndices = $this->getBook()->getIndex();
        
        $i = 0;
        
        foreach($bIndices as $index) {
            
            $object->sectionData[$i] = new \stdClass();
            
            $object->sectionData[$i]->id = $index->id;
            $object->sectionData[$i]->title = $index->title;
            $object->sectionData[$i]->parent = $index->parent;
            $object->sectionData[$i]->order = $index->order;
            
            $i++;
            
        }
        
        if($this->hasTranslation()) {
            
            $paragraphs = \App\ParagraphTranslation::where('translated_book', '=', $this->id)->orderBy('paragraph_count', 'ASC')->get();
            
            $sentences = [];
            
            $sentenceCount = 0;
            
            $lastSection = -1;
            $sentencesInSection = 0;
            
            $lastTestGroup = -1;
            $sentencesInTestGroup = 0;
            
            foreach($paragraphs as $paragraph) {
                
                $originalParagraph = \App\Paragraph::findOrFail($paragraph->original_paragraph);
                
                if($lastSection != $originalParagraph->parent_index) {
                    
                    $sentencesInSection = 0;
                    
                }
                
                if($lastTestGroup != $originalParagraph->test_group) {
                    
                    $sentencesInTestGroup = 0;
                    
                }
           
                $sentencesInParagraph = json_decode($originalParagraph->paragraph_sentences);
                
                for($i = 0; $i < count($sentencesInParagraph); $i++) {
                    
                    $sentenceToAdd = new \stdClass();
  
                    $sentenceToAdd->sentence = $sentencesInParagraph[$i];
                    $sentenceToAdd->translation = json_decode($paragraph->sentences)[$i];

                    $sentenceToAdd->section = $originalParagraph->parent_index;
                    $sentenceToAdd->orderInSection = $sentencesInSection;
                    
                    // test groups are like paragraphs. the user meant for them to be a single test,
                    // and not seperated. while paragraphs cannot actually exist, this kind of blocking
                    // is the most relevant to paragraphs. we'll just drop the test group since it's for our own
                    // usage, and provide the order for sentences in the test group instead.
                    
                    // we are making the assumption that all test groups are ordered by our query. if that changes, this will break.
                    $sentenceToAdd->testGroup = $originalParagraph->test_group;
                    $sentenceToAdd->orderInTestGroup = $sentencesInTestGroup;
                    
                    $sentenceToAdd->orderInBook = $sentenceCount;
                    
                    $sentences[$sentenceCount] = $sentenceToAdd;
                    
                    $sentenceCount++;
                    $sentencesInSection++;
                    $sentencesInTestGroup++;
                    
                }
                
                $lastTestGroup = $originalParagraph->test_group;
                $lastSection = $originalParagraph->parent_index;
                
                
            }
            
            $object->sentenceData = $sentences;
            
            $jsonData = json_encode($object, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            
            $fileName = $this->getJSONFileName();
            $directory = '/data/book_translations/';
            $fileExtension = $this->getJSONFileExtension();
            
            $path = $directory . $fileName . $fileExtension;
            
            if(Storage::put($path, $jsonData)) {
                
               $filePath = $path; 
               
               $this->json_file = $filePath;
               
               if(!$this->save()) {
                   
                   throw new \Exception('There was a problem setting the json file in the database.');
                   
               }
               
                
            } else {
                
                throw new \Exception('There was a problem storing the file.');
                
            }
            
            
        } else {
            
            throw new \Exception('The book has not yet been translated.');
            
        }
        
        return $filePath;
        
    }
    
    public function getJSONFileName() {
        
        $book = $this->getBook();
        
        return $book->getLanguage()->language . '-' . $this->getLanguage()->language . '-' . $book->getTitle() . '-' . $book->getAuthor();
        
    }
    
    public function getJSONFileExtension() {
        
        return '.json';
        
    }
    
    public function getJsonFileNameWithExtension() {
        
        return $this->getJSONFileName() . $this->getJSONFileExtension();
        
    }
    
    
    // As it goes through the original book, it adds words it finds
    // to a trie. If the trie is defined it skips it. If the trie is 
    // not defined, it defines the word as found. It then checks the dictionary
    // for original language to this language to see if there is a defined definition.
    // If there isn't, it increments the word characters not found in the dictionary by
    // the mb_strlen (length) of the word. 
    
    // After processing all of the words in this book, it saves this new total. This is used
    // for pricing how much a translation will cost.
    public function updateWordCharactersNotInDictionary() {
        
        set_time_limit(5000);
        
        // The justification for doing this is that a language usually is 50k-200k words. 
        // 5 letters per word = 1-2m characters. (using as much memory as the book)
        $wordsInDictionaryTrie = Dictionary::buildDictionaryTrie($this->original_language, $this->translation_language);
        
        $wordsInBookTrie = new \App\Trie();
        
        $wordsInBook = $this->getBook()->getAllWordsInBook(); 
        
        $count = 0;
        
        // Does the comments at the beginning of this method.
        foreach($wordsInBook as $word) {
            
            if(strlen($word) == 0) {
                
                continue;
            }
            
            $currentWordTrie = $wordsInBookTrie->getTrieAtWord($word);
            
            if(!$currentWordTrie->hasWordEnding()) {
                
                if(!$wordsInDictionaryTrie->containsWord($word)) {
                    
                    $count += mb_strlen($word, 'UTF-8');
                    
                }
                
                $currentWordTrie->setAsWord();
               
                
            }
            
        }
        
        $this->characters_not_in_dictionary = $count;
        
        return $this->save();
        
    }
    
    // Service fee is hardcoded in so that it translates better across languages.
    public function getPricing() {
        
        $book = $this->getBook();
        
        return number_format(Math::roundUp(($book->characters + $this->characters_not_in_dictionary) * (20 / 1000000), 3) + 5.00, 2); 
        
    }
    
    
}
