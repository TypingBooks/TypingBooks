<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use App\Book;
use App\BookTranslation;

class ImportBook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $book;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Book $book)
    {
        $this->book = $book;
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
        
        $book = $this->book;
        
        if(config('app.debug') == false) {
            
            SendDiscordMessage::dispatch($book->getDiscordMessage(), 'https://discordapp.com/api/webhooks/726675850841554986/KL7_N4aCe_18sB3IAT0NHva2wbAtc1ANhUDeIjbO2H0g__yQc5nfYxnbiIrNMvWPdiAf');
                 
        }
        
        DB::transaction(function () use ($book) {
            
            if($book->fillDatabaseWithContents() 
                && $book->updateAmountOfCharactersInBook() 
                && $book->updateAmountOfCharactersFoundInWords()) {
                    
                $book->amount_of_paragraphs = count(\App\Paragraph::where('book', '=', $book->id)->get());
                
                if($book->save()) {
                    
                    $landings = \App\LearningLanding::where('learning_lang', '=', $book->language)->get();
                    
                    foreach($landings as $landing) {
                        
                        if(!$book->createBaseTranslationBook(\App\Language::find($landing->native_lang), $landing)) {
                            
                            throw new \Exception("Failed to create a base translation for this book.");
                            
                        }
                
                    }
                           
                } else {
                    
                    throw new \Exception('Failed to update the amount of paragraphs found within the book');
                    
                }
                
            } else {
                
                // it's one of the last two
                throw new \Exception('Something went wrong while filling the database with data');
                
            }
                
            
        });
        
        
        // The two jobs dispatched below must be done outside of the transaction. Even though they can interact with the 
        // model in the current context, the queue can start executing them immediately. Since the jobs are not actually
        // in the database until the transaction is committed, they sometimes will beat the transaction commit and cause
        // their own jobs to fail. Since they're below, the transaction has already been comitted.
        $defaultTranslation = \App\BookTranslation::where('book', '=', $book->id)->where('translation_language', '=', $book->getLanguage()->id)->firstOrFail();
        
        if (!App::environment('staging')) {
            
            \App\Jobs\TranslateBook::dispatch($defaultTranslation, $book, false)->onQueue('default_long');
            
        }
        
        $translations = BookTranslation::where('book', '=', $book->id)->get();
        
        foreach($translations as $translation) {
            
            UpdateBookPricing::dispatch($translation);
            
        }
         
    }
}
