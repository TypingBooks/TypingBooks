<?php

namespace App\Jobs;

use App\Book;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use App\Paragraph;

class ReplaceTextInBook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $book;
    protected $replaceText;
    protected $replaceWith;
    protected $isRegex;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Book $book, $replaceText, $replaceWith, $isRegex)
    {
        $this->book = $book;
        $this->replaceText = $replaceText;
        $this->replaceWith = $replaceWith;
        $this->isRegex = $isRegex;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
        $book = \App\Book::findOrFail($this->book->id);
        $temp = $this;
        
        DB::transaction(function() use ($book, $temp) {
            
            $book->replaceInBook($temp->replaceText, $temp->replaceWith, $temp->isRegex, $book->getPunctuationMap());
            
        });
 
    }
}
