<?php

namespace App\Jobs;

use App\BookTranslation;
use App\Dictionary;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateDataArchive implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
        set_time_limit(10000);
        ini_set('memory_limit','2048M'); 
        
        $zipFileName = 'all_data';
        $zipFileExtension = '.zip';
        
        $zipFile = storage_path('app/data/' . $zipFileName . $zipFileExtension);
        
        $zip = new \ZipArchive();
        $zip->open($zipFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        
        $booksWithTranslations = BookTranslation::where('book_translations.json_file', '!=', null)
                                                ->where('book_translations.has_translation', '=', true)
                                                ->where('book_translations.is_active', '=', 1)
                                                ->where('books.passed_validation_by_user', '=', 1)
                                                ->join('books', 'books.id', '=', 'book_translations.book')
                                                ->join('users', 'users.id', '=', 'books.added_by')
                                                ->select('book_translations.*', 'books.title', 'books.author', 'books.added_by', 'users.name')
                                                ->where('books.is_private', '=', 0)
                                                ->get();
        
        
        $translationsPathInArchive = 'data/book_translations/';
        
        foreach($booksWithTranslations as $book) {
            
            if(!$zip->addFile(storage_path('app' . $book->json_file), $translationsPathInArchive . $book->getJsonFileNameWithExtension())) {
                
                throw new \Exception('Failed to add book translation to zip file.');
                
            }
            
        }
        
        $dictionaryPathInArchive = 'data/dictionaries/';
        
        $dictionaries = Dictionary::where('json_file', '!=', null)->get();
        
        foreach($dictionaries as $dictionary) {
            
            if(!$zip->addFile(storage_path('app' . $dictionary->json_file), 
                $dictionaryPathInArchive . $dictionary->getJsonFileNameWithExtension())) {
                    
                    throw new \Exception('Failed to add dictionary to zip file.');
                    
                }
            
        }
        
        if(!$zip->close()) {
            
            throw new \Exception('Failed to create/overwrite zip file.');
            
        }
        
    }
}
