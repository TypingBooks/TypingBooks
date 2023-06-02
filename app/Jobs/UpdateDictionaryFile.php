<?php

namespace App\Jobs;

use App\Dictionary;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateDictionaryFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dictionary;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Dictionary $dictionary)
    {
        $this->dictionary = $dictionary;
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
        
        if($this->dictionary->file_needs_update) {
            
            if(!$this->dictionary->updateDictionaryJsonFile()) {
                
                throw new \Exception('Failed to update the json file for this dictionary.');
                
            } else {
                
                // And since the dictionary has been updated, then pricing might have changed for books
                // that need a similar translation. (ex. eng to russian books)
                
                $booksNeedingPricingUpdates = $this->dictionary->getBooksWaitingForSimilarTranslation();
                
                foreach($booksNeedingPricingUpdates as $book) {
                    
                    // I think I saw these were using much
                    // more memory than originally expected.
                    // A normal book/dictionary has like 2m
                    // characters. Each characters is a byte.
                    
                    // 4m / 1000 bytes = 4000 KB / 1000 KB = 4 MB..
                    // Though, creating the objects/trie is apparently expensive
                    // (like I saw out of memory errors for like 100MB file.
                    
                    // My math was probably wrong... but not that wrong. If each
                    // character allocates 28 bytes (the normal amount in a alphabet)
                    // then a million characters can cost 28 MB. Though, each character
                    // shouldn't actually need 28 bytes. (repeated words + not every combination)
                    // of characters should happen. 
                    
                    // It might be a decent idea to actually specify alphabet sizes so that PHP 
                    // doesn't allocate more memory than necessariy... but that'd be really complex. 
                    // ..and also completely fails on languages similar to Chinese.
                    
                    // Anyway, some of these jobs might fail if my memory is correct
                    // ex. 8 queue workers using huge amounts of memory all at once
                    UpdateBookPricing::dispatch($book);
                    
                }
                
            }
        
        }
    }
}
