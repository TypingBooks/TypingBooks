<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\BookTranslation;

class ValidateBookTranslation implements ShouldQueue
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
        
        if(!$this->book->updateValidationState()) {
            
            throw new \Exception('Failed to update the validation state for this book');
            
        }
        
    }
}
