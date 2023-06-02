<?php

namespace App\Jobs;

use App\BookTranslation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateBookJsonFile implements ShouldQueue
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
        
        if($this->book->buildAndCreateJSONFile() == null) {
            
            throw new \Exception('Failed to create the JSON file for this book.');
            
        }
        
    }
}
