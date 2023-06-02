<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\StringTools;

class Settings extends Model
{
    
    public function getPrintedReplaceList() {
        
        return StringTools::getPrintedReplaceList($this->global_replace_characters);
    
    }
    
    public function getJSONReplaceList() {
        
        return $this->global_replace_characters;
        
    }
    
    public function getWhitelist() {
        
        return $this->gloabl_whitelisted_characters;
        
    }
    
    public function getReplaceList() {
        
        return $this->global_replace_characters;
        
    }
    
    public function getReplaceListArray() {
        
        return json_decode($this->getReplaceList());
        
    }
   
    
    public function useWhitelist() {
        
        return true;
        
    }
    
    public function getPunctuationList() {
        
        return $this->global_punctuation_characters;
        
    }
    
    
    public function saveToJSONReplaceList($text) {
        
        $text = \App\StringTools::createJSONReplaceList($text);
        
        $this->global_replace_characters = $text;
        
        return $this->save();
        
    }
    
    
    
}
