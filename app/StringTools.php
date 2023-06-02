<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StringTools extends Model
{
   
    // Checks if the data passed in is punctuation
    // Note: Since this is raw data from the the text file,
    // not all symbols passed in will actually be defined characters
    // some characters are multiple bytes in length, and I think
    // that this is just passing a single byte. It's possible that
    // some characters are split, creating undefined characters
    public static function isPunctuation($character) {
        
        return $character == '!' || $character == '.' || $character == '?';
        
        
    }
    
    // Replaces substrings in the string, if what it was replaced with 
    // creates another occurence of the value to be replaced, it will also
    // be replaced
    public static function replaceUntilNoMatch($text, $replace, $replaceWith) {
        
        if(strlen($text) == 0) {
            
            return '';
            
        }
        
        while(str_contains($text, $replace)) {
            
            $text = str_replace($replace, $replaceWith, $text);
            
        }
        
       return $text;
    }
    
    public static function stringContainsPunctuation($string) {
        
        for($i = strlen($string) - 1; $i >= 0; $i--) {
            
            if(StringTools::isPunctuation($string[$i])) {
                
                return true;
                
            }
            
        }
        
        return false;
        
    }
    
    public static function stringContainsPunctuation2($string, $punctuationMap) {
        
        $string = StringTools::createUTF8CharacterArrayFromString($string);
        
        foreach($string as $character) {
            
            if(isset($punctuationMap[$character])) {
                
                return true;
                
            }
            
        }
        
        return false;
        
    }
    
    public static function getSentenceArrayFromWords($words) {
        
        $sentences = [];
        $count = 0;
        
        $startOfSentence = true;
        
        foreach($words as $word) {
            
            if($sentences[$count] == null) {
                
                $sentences[$count] = '';
                
            }
            
            if($startOfSentence) {
                
                $sentences[$count] = $word;
                $startOfSentence = false;
                
            } else {
                
                $sentences[$count] = $sentences[$count] . ' ' . $word;
                
            }
            
            if(StringTools::stringContainsPunctuation($word)) {
                
                $count++;
                $startOfSentence = true;
                
            }
            
        }
        
        return $sentences;
        
    }
    
    // Removes punctuation/formatting characters from a string
    public static function removeNonWordCharacters($string) {
        
        $newString = '';
        
        for($i = 0; $i < strlen($string); $i++) {
            
            if(!\App\StringTools::isNonWordCharacter($string[$i])) {
                
                $newString = $newString . $string[$i];
                
            }
            
        }
        
        return $newString;
        
    }
    
    public static function createJSONReplaceList($text) {
        
        // There are better ways.. but oh well.
        $text = StringTools::replaceUntilNoMatch($text, ' ', '');
        $text = StringTools::replaceUntilNoMatch($text, "\r", '');
        $text = StringTools::replaceUntilNoMatch($text, "\n", '|');
        $text = StringTools::replaceUntilNoMatch($text, '||', '|');
        $text = StringTools::replaceUntilNoMatch($text, '::', ':');
        
        $text = explode('|', $text);
        
        for($i = 0; $i < count($text); $i++) {
            
            $text[$i] = explode(':', $text[$i]);
            
            if(count($text[$i]) < 2) {
                
                if(count($text[$i]) == 1) {
                    
                    $text[$i][1] = $text[$i][0];
                    
                } else if(count($text[$i]) == 0) {
                    
                    $text[$i][0] = 'a';
                    $text[$i][1] = 'a';
                    
                }
                
            }
            
            if(strlen($text[$i][0]) == 0) {
                
                if(strlen($text[$i][1]) != 0) {
                    
                    $text[$i][0] = $text[$i][1];
                    
                } else {
                    
                    $text[$i][0] = 'a';
                    $text[$i][1] = 'a';
                    
                }
                
            }
            
            if(strlen($text[$i][1]) == 0) {
                
                $text[$i][1] = $text[$i][0];
                
            }
            
        }
        
        return json_encode($text, JSON_UNESCAPED_UNICODE);
        
    }
    
    public static function createUTF8CharacterArrayFromString($string) {
        
        return preg_split('//u', $string, null, PREG_SPLIT_NO_EMPTY);
        
    }
    
    public static function createStringFromUTF8CharacterArray($UTF8CharacterArray) {
        
        $string = '';
        
        foreach($UTF8CharacterArray as $char) {
            
            $string = $string . $char;
            
        }
        
        return $string;
        
    }
    
    public static function convertToUTF8($string) {
        
        $encoding = mb_detect_encoding($string);
        
        $string = mb_convert_encoding($string, $encoding, 'UTF-8');
        
        return $string;
        
    }
    
    public static function findCharactersNotInWhitelist($text, $whitelist) {
        
        // adding the marking that is used for new lines
        $whitelist = $whitelist . '|';
        
        $index = 0;
        $charactersNotInWhitelist = [];
        
        // create a whitelisted hashmap
        $whitelistMap = [];
        
        $whitelistCharacters = StringTools::createUTF8CharacterArrayFromString($whitelist);
        
        foreach($whitelistCharacters as $char) {
            
            $whitelistMap[$char] = true;
            
        }
        
        $blacklisted = [];
        
        $charactersInText = StringTools::createUTF8CharacterArrayFromString($text);
        
        foreach($charactersInText as $character) {
            
            // check if every character is in the whitelist
            if(!isset($whitelistMap[$character])) {
            
                // if it isn't, and it hasn't already been added to the 
                // blacklist, then it's added to the blacklist. 
                // (or the list that tracks characters that need replacements)
                if(!isset($blacklisted[$character])) {
                    
                    $blacklisted[$character] = true;
                    $charactersNotInWhitelist[$index] = $character;
                    $index++;
                    
                } 
            
            }
            
        }
        
        return $charactersNotInWhitelist;
        
    }
    
    public static function useReplaceArrayOnText($text, $replaceArray) {
        
        if(count($replaceArray) == 0) {
            
            return $text;
            
        }
        
        if(strlen($text) == 0) {
            
            return '';
            
        }
        
        $length = count($replaceArray);
        
        for($i = 0; $i < $length; $i++) {
            
            $text = str_replace($replaceArray[$i][0], $replaceArray[$i][1], $text);
            
        }
        
        return $text;
        
    }
    
    public static function combineJSONReplaceLists($list1, $list2) {
        
        // feeling kind of lazy...
        
        $string1 = StringTools::getPrintedReplaceList($list1);
        $string2 = StringTools::getPrintedReplaceList($list2);
        
        return StringTools::createJSONReplaceList($string1 . "\r\n" . $string2);
        
    }
    
    public static function getCombinedReplaceArraysFromJSON($list1, $list2) {
        
        return json_decode(combineJSONReplaceLists($list1, $list2));
        
    }
    
    public static function getPrintedReplaceList($JSONReplaceList) {
        
        if(strlen($JSONReplaceList) == 0) {
            
            return $JSONReplaceList;
            
        }
        
        
        $list = json_decode($JSONReplaceList);
        
        $string = '';
        
        for($i = 0; $i < count($list); $i++) {
            
            if($i != count($list) - 1) {
                
                $string = $string . $list[$i][0] . ':' . $list[$i][1] . "\r\n";
                
            } else {
                
                $string = $string . $list[$i][0] . ':' . $list[$i][1];
                
            }
            
        }
        
        return $string;
        
        
    }
    
    
    // Since this is checking binary data and not the encoded
    // characters, it might not always work as expected.
    public static function isNonWordCharacter($character) {
        
        if(ord($character) < 48 
            || ord($character) > 57 && ord($character) < 65 
            || ord($character) > 90 && ord($character) < 97 
            || ord($character) > 122 && ord($character) < 128) {
            
               return true;
            
        } else if($character == '-') {
                
            return true;
            
        }
        
        return false;
        
    }
    
}
