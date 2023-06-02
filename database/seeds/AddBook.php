<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class AddBook extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $russian = \App\Language::where('abbreviation', '=', 'ru')->first();
             
        if(!\App\Book::createBook('Анна Каренина', 'Leo Tolstoy', $russian->id, 'books/Анна Каренина.txt')) {
            
            throw new Exception('Failed to fill the database with this book.');
            
        }
        
        // create a test translation
        
        /*
         *  Lol, this will take like an hour. Indexing hasn't been done, and json_decode over and over
         */
        
        /*
        $english = \App\Language::where('abbreviation', '=', 'en')->first();
        
        $testBookTranslation = \App\BookTranslation::where('translation_language', '=', $english->id)->first();
        
        $c = new \App\Http\Controllers\BookTranslationController();
        $c->confirmOrder($testBookTranslation->id);
        */
        
    }
}
