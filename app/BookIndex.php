<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookIndex extends Model
{
    
    public function getChildren() {
        
        $indices = BookIndex::where('book', '=', $this->book)->where('parent', '=', $this->id)->orderBy('order', 'ASC')->get();
        
        return $indices;
        
    }
    
    public function getParent() {
        
        return BookIndex::find($this->parent);
        
    }
    
    public function hasParent() {
        
        return $this->getParent() != null;
        
    }
    
    public function getHTMLChildren() {
        
        $children = $this->getChildren();
        
        $html = '<li>' . htmlspecialchars($this->title);
        
        if(count($children) > 0) {
            
            $html = $html . '<ol>';
        
            foreach($children as $child) {
                $html = $html . $child->getHTMLChildren();         
            }
        
            $html = $html . '</ol>';
            
        }
        
        $html = $html . '</li>';
        
        return $html;
        
    }
    
}
