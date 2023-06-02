<?php

use Illuminate\Database\Seeder;
use App\Jobs\TransitionLegacyBook;

class MigrateLegacyBooks extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $books = \App\Book::get();
        
        foreach($books as $book) {
            
            TransitionLegacyBook::dispatch($book)->onQueue('default_long');
            
        }
        
        $translations = \App\BookTranslation::where('has_translation', '=', true)->get();
        
        // This will force it to create a new JSON file for this book.
        foreach($translations as $book) {
            
            $book->json_file = null;
            
            $book->save();
            
        }
    }
}
