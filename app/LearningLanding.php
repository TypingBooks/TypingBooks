<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LearningLanding extends Model
{
  
    public function getBooks() {
        
        return \App\BookTranslation::where('learning_landing', '=', $this->id)->get();
        
    }
    
    public function getBooksWaitingForTranslation() {
        
        return \App\BookTranslation::where('learning_landing', '=', $this->id)->where('has_translation', '=', false)->get();
        
    }
    
    
}
