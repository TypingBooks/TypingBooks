<?php

namespace App\Jobs;

use App\BookTranslation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateBookPricing implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    
    protected $book;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(BookTranslation $book)
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
        
        if(!$this->book->updateWordCharactersNotInDictionary()) {
            
            throw new \Exception('Failed to update the pricing for this book.');
            
        }
    }
}
