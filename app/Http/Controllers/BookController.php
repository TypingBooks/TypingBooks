<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /* 
     * 
     * The methods in this file are only for admins. I didn't care if they were secure. Use the methods in the ImportController.
     * 
     */
    
    
    public function import() {
        
        $languages = \App\Language::get();
        
        return view('admin/import', compact('languages'));
        
    }
    
    public function saveBook(Request $request) {
        
        $path = $request->file('book')->store('books');
        
        if(\App\Book::createBook($request->title, $request->author, $request->language, $path)) {
            
            return redirect()->back()->with('success', 'This book has been added to the database');
            
        } 
        
        return redirect()->back()->with('error', 'There was a problem while importing this book.');
        
    }
    
}
