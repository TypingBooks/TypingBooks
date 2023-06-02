<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Dictionary extends Model
{
    
    // Builds and returns the Trie for all dictionary items in a language
    // Expected to consist of 50,000 - 200,000 words.
    public static function buildDictionaryTrie($from_language, $to_language) {
        
        $dictionary = Dictionary::getAllItemsInDictionary($from_language, $to_language);
        
        $trie = new Trie();
        
        for($i = 0; $i < count($dictionary); $i++) {
            
            $tempTrie = $trie->getTrieAtWord($dictionary[$i]->word);
            $tempTrie->setAsWord();
            $tempTrie->setStoredString($dictionary[$i]->translation);
            
        }
        
        return $trie;
        
    }
    
    public static function getAllItemsInDictionary($from_language, $to_language) {
        
        return DictionaryItem::where('from_language', '=', $from_language)->where('to_language', '=', $to_language)->orderBy('word', 'ASC')->get();
        
    }
    
    public function createDictionaryJsonFile() {
        
        $object = new \stdClass();
        $object->language = $this->getFromLanguage()->language;
        $object->translationLanguage = $this->getToLanguage()->language;
        $object->dictionaryItems = [];
        
        $from_language = $this->from_language;
        $to_language = $this->to_language;
        
        $dictionaryItems = Dictionary::getAllItemsInDictionary($from_language, $to_language);
        
        $dictionary = [];
        
        for($i = 0; $i < count($dictionaryItems); $i++) {
            
            $item = new \stdClass();
            $item->word = $dictionaryItems[$i]->word;
            $item->translation = $dictionaryItems[$i]->translation;
            
            $dictionary[$i] = $item;
            
        }
        
        // Creating a fake item if there are no items
        // so that all JSON files are consistent in structure.
        if(count($dictionaryItems) == 0) {
            
            $item = new \stdClass();
            $item->word = ' ';
            $item->translation = ' ';
            
            $dictionary[0] = $item;
            
        }
        
        $object->dictionaryItems = $dictionary;
        
        $json = json_encode($object, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        
        $directory = '/data/dictionaries/';
        $fileName = $this->getJSONFileName();
        $fileExtension = $this->getJSONFileExtension();
        
        $path = $directory . $fileName . $fileExtension;
        
        if(!Storage::put($path, $json)) {
            
            throw new \Exception('There was an error storing the file.');
            
        }
        
        return $path;
        
    }
    
    public function getJSONFileName() {
        
        $lang1 = Language::find($this->from_language);
        $lang2 = Language::find($this->to_language);
        
        return $lang1->language . '-' . $lang2->language;
        
    }
    
    public function getJSONFileExtension() {
        
        return '.json';
        
    }
    
    public function getJsonFileNameWithExtension() {
        
        return $this->getJSONFileName() . $this->getJSONFileExtension();
        
    }
    
    public function updateDictionaryJsonFile() {
        
        $this->file_needs_update = false;
        $this->save();
        
        $this->json_file = $this->createDictionaryJsonFile();
        
        $temp = Dictionary::find($this->id);
        
        // A job is running that is also updating dictionary items.
        // It really wouldn't be good to have a paragraph translations
        // fail over and over because they can't acquire a lock to update
        // dictionary files. It seems like a better idea to just to throw an exception
        // so that it ends up back in the queue. 
        if($temp->file_needs_update) {
            
            //throw new \Exception('A book translation is running.');
            
            // The above problem is actually fine. I went back and fixed it.
            // Though, I'm leaving the comments so that it is obvious
            // in the future that this is accounted for.
            
            // The cron job that calls this was changed to only
            // update the dictionary when translations are 100%
            // complete.
            
        }
        
        return $this->save();
        
    }
    
    public function getLocationOfJsonFile() {
        
        return $this->json_file;
        
    }
    
    public function getDictionaryJsonFile() {
        
        if(isset($this->json_file)) {
            
            return Storage::get($this->json_file);
            
        }
        
        return null;
        
    }
    
    public function hasDictionaryJsonFile() {
        
        return isset($this->json_file);
        
    }
    
    public function getFromLanguage() {
        
        return \App\Language::find($this->from_language);
        
    }
    
    public function getToLanguage() {
        
        return \App\Language::find($this->to_language);
        
    }
    
    public function getLanding() {
        
        return \App\LearningLanding::find($this->landing);
        
    }
    
    public static function getDictionaryWithLanguages($from_language, $to_language) {
        
        return Dictionary::where('from_language', '=', $from_language)->where('to_language', '=', $to_language)->first();
        
    }
    
    // I think these are all incorrect. I'll to fix later.
    public static function getDictionaryFromLanding($landing) {
        
        return Dictionary::where('landing', '=', $landing)->first();
        
    }
    
    public static function getDictionaryRelatedToBookTranslation($bookTranslation) {
        
        return Dictionary::getDictionaryWithLanguages($bookTranslation->original_language, $bookTranslation->translation_language);   
        
    }
    
    
    public function getBooksWaitingForSimilarTranslation() {
        
        return $this->getLanding()->getBooksWaitingForTranslation();
        
    }
    
    
    
}
