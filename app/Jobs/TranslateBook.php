<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\BookTranslation;
use App\Book;

class TranslateBook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $translationBook;
    protected $originalBook;
    protected $isReal;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(BookTranslation $translationBook, Book $originalBook, $isReal = false)
    {
        
        $this->translationBook = $translationBook;
        $this->originalBook = $originalBook;
        $this->isReal = $isReal;
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {   
        set_time_limit(10000);
        
        $translationBook = $this->translationBook;
        $book = $this->originalBook;
        
        if(config('app.debug') == false  && !$book->is_private) {
           
            if($this->originalBook->getLanguage()->id != $this->translationBook->getLanguage()->id) {
            
                SendDiscordMessage::dispatch($translationBook->getDiscordMessage());
               
            }
            
        }
        
        $translationBook->has_translation = true;
        
        if(!$translationBook->save()) {
            
            throw new \Exception('Failed to update the status of this translation');
           
        }
        
        $bookParagraphs = \App\Paragraph::where('book', '=', $book->id)->get();
        
        foreach($bookParagraphs as $bookParagraph) {
            
            // Since unknown problems could happen with a paragraph translation (on the host side)
            // it seems like a much better idea to handle retries at the individual paragraph level
            // than trying to do them all at once in a pass/fail style. (in the event some fail, they can
            // just be retried later/reported as failed (to debug)
            TranslateParagraphForBook::dispatch($bookParagraph, $book, $translationBook, $this->isReal);
            
        }
        
    }
}
