<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Google\Cloud\Translate\V2\TranslateClient;

class TranslationBrain extends Model
{
    
    public static function translateWord($word, $from_language, $to_language, $isReal = false) {
        
        $cleanedWord = \App\StringTools::removeNonWordCharacters($word);
        $cleanedWord = mb_strtolower($cleanedWord, mb_detect_encoding($cleanedWord));
        
        $dictionaryLookup = \App\DictionaryItem::where('from_language', '=', $from_language)->where('to_language', '=', $to_language)->where('word', '=', $cleanedWord)->first();
        
        if(isset($dictionaryLookup)) {
            
            return $dictionaryLookup->translation;
            
        } else {
            
            $d1 = new \App\DictionaryItem();
            
            $translatedWord = \App\TranslationBrain::translateUsingProvider($cleanedWord, $from_language, $to_language, $isReal); // this will be grabbed using the api
            
            $d1->from_language = $from_language;

            $d1->to_language = $to_language;
            $d1->word = $cleanedWord;
            $d1->translation = $translatedWord;
            
            // When translating a book, this will probably happen a lot... There also isn't a lock, so at the moment,
            // it's just kind of expecting that if a job is running that is updating these files, that it will be marked 
            // for update again. It's all around not that great.
            $dictionary1 = \App\Dictionary::where('from_language', '=', $from_language)->where('to_language', '=', $to_language)->first();
            // These dictionaries are made available for download after they've been updated
            // They also are used to update pricing.
            $dictionary1->file_needs_update = true;
            
            $saved = false;
            
            // As with the other loop below, these are just to try to not lose
            // a translation for some weird issue with the database not saving
            for($i = 0; $i < 5 && !$saved; $i++) {
                
                $saved = $dictionary1->save();
                
            }
            
            if(!$saved) {
                
                throw new \Exception('Failed to mark the relevant dictionaries for update.');
                
            }
            
            $saved = false;
            
            for($i = 0; $i < 5 && !$saved; $i++) {
                
                $saved = $d1->save();
                
            }
            
            if(!$saved) {
                
                throw new \Exception("Failed to save dictionary item.");
                
            }
            
            $dictionaryLookup = $d1;
            
        }
        
        return $dictionaryLookup->translation;
        
    }
    
    public static function translateWords($words, $from_language, $to_language, $isReal = false) {
        
        for($i = 0; $i < count($words); $i++) {
            
            $words[$i] = \App\TranslationBrain::translateWord($words[$i], $from_language, $to_language, $isReal);
            
        }
     
        return $words;
        
    }
    
    public static function translateSentence($sentence, $from_language, $to_language, $isReal = false) {
        
        //in the real version, it will get the translation from somewhere else;
        
        return \App\TranslationBrain::translateUsingProvider($sentence, $from_language, $to_language, $isReal);
        
    }
    
    public static function translateSentences($sentences, $from_language, $to_language, $isReal = false) {
        
        for($i = 0; $i < count($sentences); $i++) {
            
            $sentences[$i] = \App\TranslationBrain::translateSentence($sentences[$i], $from_language, $to_language, $isReal);
            
        }
        
        return $sentences;
        
    }
    
    public static function translateUsingProvider($string, $from_language, $to_language, $isReal = false) {
            
        if($isReal && App::environment('production')) {
        
            $from_language = \App\Language::findOrFail($from_language);
            $to_language = \App\Language::findOrFail($to_language);
            
            $translate = new TranslateClient([
                'key' => config('google_translate.api_key'),
            ]);
            
            $result = $translate->translate($string, [
                'target' => $to_language->abbreviation,
                'source' => $from_language->abbreviation,
            ]);
            
            $string =  $result['text'];
            
            
        }
        
        
        return $string;
        
    }
    
    
}
