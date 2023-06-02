<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    
    public function getBook() {
        
        return \App\BookTranslation::findOrFail($this->book_translation);
        
    }
    
    public function getProgress() {
        
        return $this->getBook()->getTranslationProgress();
 
    }
    
    // If the order is attached to a user
    // it returns their default locale.
    // Otherwise, it returns what the language is of 
    // the book translation
    public function getLocale() {
        
        if($this->hasUser()) {
            
            return $this->getUser()->getLocale();
            
        }
        
        return $this->getBook()->getLanguage()->abbreviation;
        
    }
    
    public function hasUser() {
        
        return $this->user != null;
        
    }
    
    public function getContact() {
        
        if($this->hasUser()) {
            
            return $this->getUser()->email;
            
        }
        
        return null;
        
    }
    
    public function getAddress() {
        
        return url('/purchase/complete/' . $this->id);
        
    }
    
    public function getUser() {
        
        if($this->hasUser()) {
            
            return \App\User::findOrFail($this->user);
            
        }
        
        return null;
        
    }
    
    // Mail won't ever have the locale set, so, these values are 
    // pretty useless. They've been changed to just return
    // the location in locale translations
    public function getFormattedState() {
        
        if($this->state == 'complete') {
            
            $progress = $this->getBook()->getTranslationProgress();
            
            if($progress == 100) {
                
                return 'order_details.complete';
                
            } else {
                
                return 'order_details.translating';
                
            }
                
            
        }
        
        return 'order_details.pending';
            
    }
    
    
    
}
