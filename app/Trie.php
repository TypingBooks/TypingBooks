<?php

namespace App;

class Trie {
    
    protected $trieArray = [];
    protected $count = 0;
    protected $stringStorage = '';
    
    public function __construct($isKnownEnd = false) {

        $this->trieArray = [];
        $this->count = 0;
        $this->stringStorage = '';
        
        if($isKnownEnd)
            $this->count++;

            
    }
 
    public function hasStringStored() {
        
        return $this->stringStorage != '';
        
    }
    
    public function getStoredString() {
        
        return $this->stringStorage;
        
    }
    
    public function setStoredString($string) {
        
        $this->stringStorage = $string;
        
    }
    
    public function hasWordEnding() {
        
        return $this->count > 0 || $this->hasStringStored();
        
    }
    
    public function getTrie($letter) {
        
        if(empty($this->trieArray[$letter])) {
            
            $this->trieArray[$letter] = new Trie();
            
        }
        
        return $this->trieArray[$letter];
        
    }
    
    public function getWordCount() {
        
        return $this->count;
        
    }
    
    public function getTrieAtLetter($letter) {
        
        if($this->trieArray[$letter] == null) {
            
            $this->trieArray[$letter] = new Trie($letter);
            
        }
        
        return $this->trieArray[$letter];
        
        
    }
    
    public function setAsWord() {
        
        $this->count++;
        
    }
    
    public function incrementWordSeen() {
        
        $this->count++;
        
    }
    
    
    public function containsWord($word) {
        
        $currentTrie = $this;
        
        for($i = 0; $i < strlen($word); $i++) {
            
            $currentTrie = $currentTrie->getTrie($word[$i]);
            
        }
        
        return $currentTrie->hasWordEnding();
        
    }
    
    public function getTrieAtWord($word) {
        
        $currentTrie = $this;
        
        for($i = 0; $i < strlen($word); $i++) {
            
            $currentTrie = $currentTrie->getTrie($word[$i]);
            
        }
        
        return $currentTrie;
        
    }
    
    public function getStorageForWord($word) {
        
        return $this->getTrieAtWord($word)->getStoredString();
        
    }
    
    public function setStorageForWord($lookup, $storeWord) {
       
        $this->getTrieAtWord($lookup)->setStoredString($storeWord);
        
    }
    
    public function markWordAsSeen($word) {
        
        $this->getTrieAtWord($word)->hasWordEnding();
        
    }
    
}