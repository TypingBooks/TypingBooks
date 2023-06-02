<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paragraph extends Model
{
   
    public static function shouldSplit($text) {
        
        return strlen($text) >= Paragraph::$LARGEST_TEST_SIZE;
        
    }
    
    public static $LARGEST_TEST_SIZE = 1200;
      
    public static function buildSentencesWithText($text, $punctuationMap) {
        
        $text = explode(' ', $text);
        
        $sentences = [];
        $sentenceIndex = 0;
        
        foreach($text as $word) {
            
            if(!isset($sentences[$sentenceIndex])) {
                
                $sentences[$sentenceIndex] = $word;
                
            } else {
                
                $sentences[$sentenceIndex] = $sentences[$sentenceIndex] . ' ' . $word;
                
            }
            
            if(StringTools::stringContainsPunctuation2($word, $punctuationMap)) {
                
                $sentenceIndex++;
                
            }
            
        }
        
        return $sentences;
        
    }
    
    public function buildSentences2($punctuationMap) {
        
        $sentences = Paragraph::buildSentencesWithText($this->paragraph_content, $punctuationMap);
        
        $this->paragraph_sentences = json_encode($sentences, JSON_UNESCAPED_UNICODE);
        
        return $this->save();
        
    }
    
    // old and unused
     public function buildSentences() {
         
         if(!isset($punctuationMap)) {
             
             $punctuationList = $this->getBook()->getPunctuationList();
             
             $punctuationMap = [];
             
             $chars = StringTools::createUTF8CharacterArrayFromString($punctuationList);
             
             foreach($chars as $char) {
                 
                 $punctuationMap[$char] = true;
                 
             }
             
         }
        
        $words = json_decode($this->paragraph_words);
        
        $sentences = array();
        
        $currentSentence = '';
        
        for($i = 0; $i < count($words); $i++) {
            
            if(StringTools::stringContainsPunctuation($words[$i])) {
                
                $currentSentence = $currentSentence . $words[$i];
                
                array_push($sentences, $currentSentence);
                
                $currentSentence = '';
                
            } else {
                
                if($i < count($words) - 1) {
                    
                    $currentSentence = $currentSentence . $words[$i] . ' ';
                    
                } else {
                    
                    $currentSentence = $currentSentence . $words[$i];
                    array_push($sentences, $currentSentence);
                    
                }
                
            }
            
            
        }
        
        $this->paragraph_sentences = json_encode($sentences, JSON_UNESCAPED_UNICODE);
        
        return $this->save();
        
    }
    
    public function getBook() {
        
        return \App\Book::find($this->book);
        
    }
    
    
    public function getFormattedTitle() {
        
        return $this->getTitle() . ' ' . $this->getLocationInBook();
        
    }
    
    public function getTitle() {
        
        return $this->getBook()->title;
        
    }
    
    public function getLocationInBook() {
        
        $temp = \App\BookIndex::find($this->parent_index);
        
        $location = '';
        
        while($temp != null) {
                
            $location =  $temp->title  . ' ' . $location;
           
            $temp = $temp->getParent();
            
        }
        
        return $location . ' #' . ($this->order_in_section + 1);
        
    }
    
    
}
