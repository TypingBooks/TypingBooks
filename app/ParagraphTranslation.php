<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParagraphTranslation extends Model
{
   
    
    public function getBook() {
        
        return $this->getOriginalParagraph()->getBook();
        
    }
    
    public function getAuthor() {
        
        return $this->getBook()->author;
        
    }
    
    public function getOriginalParagraph() {
        
        return \App\Paragraph::find($this->original_paragraph);
        
    }
    
    public function getFormattedTitle() {
        
        return $this->getOriginalParagraph()->getFormattedTitle();
        
    }
    
    public function getLocationInBook() {
        
        return $this->getOriginalParagraph()->getLocationInBook();
        
    }
    
    public function getNextParagraph() {
        
        if($this->hasNextParagraph()) {
            
            return \App\ParagraphTranslation::where('paragraph_count', '=', $this->paragraph_count + 1)->where('translated_book', '=', $this->translated_book)->first();
            
        }
        
        return null; 
        
    }
    
    public function isLastParagraph() {
        
        if($this->hasNextParagraph()) {
            
            return false;
            
        }
            
        return true;
        
    }
    
    public function getTranslationLanguage() {
        
        return \App\Language::find($this->translation_language);
        
    }
    
    public function getOriginalLanguage() {
        
        return $this->getTranslatedBook()->getOriginalLanguage();
        
    }
    
    
    public function hasNextParagraph() {
        
        if($this->paragraph_count < $this->getBook()->amount_of_paragraphs) {
            
            return true;
            
        }
        
        return false;
        
        
    }
    
    public function getGameAddress() {
        
        return url('/game/' . $this->translated_book . '/' . $this->paragraph_count);
        
    }
    
    public function getTranslatedBook() {
        
        return \App\BookTranslation::find($this->translated_book);
        
    }
    
    public function getBookAddress() {
        
        return $this->getTranslatedBook()->getBookAddress();
        
    }
    
    
    
}
