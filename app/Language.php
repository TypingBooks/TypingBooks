<?php

namespace App;

use App\Jobs\AddLanguage;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    public static function lazyCreate($language, $abbreviation, $img) {
        
        $lang = new Language();
        
        $lang->language = $language;
        $lang->abbreviation = $abbreviation;
        $lang->img = $img;
        
        return $lang->save();
    
    }
    
    /*            $table->text('whitelisted_characters', 25000);
            $table->text('replace_characters', 25000);
            $table->text('punctuation_characters', 25000);*/
    
    public function getWhitelist() {
        
        $settings = Settings::find(1);
        
        return $this->whitelisted_characters . $settings->getWhitelist();
        
    }
    
    public function getReplaceList() {
        
        $settings = Settings::find(1);
        
        $list = StringTools::combineJSONReplaceLists($settings->getReplaceList(), $this->replace_characters);
        
        return $list;
        
    }
    
    public function getReplaceListArray() {
        
        return json_decode($this->getReplaceList());
        
    }
    
    public function useWhitelist() {
        
        return $this->use_whitelist;
        
    }
    
    public function getPunctuationList() {
        
        $settings = Settings::find(1);
        
        return $this->punctuation_characters . $settings->getPunctuationList();
        
    }
    
    
    public function getPrintedReplaceList() {
        
        return \App\StringTools::getPrintedReplaceList($this->replace_characters);
        
    }
    
    public static function createLanguage($language, $abbreviation, $img) {
        
        $lang = new Language();
        
        $lang->language = $language;
        $lang->abbreviation = $abbreviation;
        $lang->img = $img;
        
        
        if($lang->save()) {
            
            AddLanguage::dispatch($lang)->onQueue('default_long');
            
            return true;
            
        }
        
        return false;
        
    }
}
