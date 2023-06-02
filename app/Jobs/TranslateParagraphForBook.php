<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Book;
use App\BookTranslation;
use App\Paragraph;

class TranslateParagraphForBook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $paragraphToTranslate;
    protected $originalBook;
    protected $translationBook;
    protected $isReal;
    
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Paragraph $paragraphToTranslate, Book $originalBook, BookTranslation $translationBook, $isReal = false)
    {
        $this->translationBook = $translationBook;
        $this->originalBook = $originalBook;
        $this->paragraphToTranslate = $paragraphToTranslate;
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
        
        $translationParagraph = new \App\ParagraphTranslation();
        $translationParagraph->words = json_encode(\App\TranslationBrain::translateWords(json_decode($this->paragraphToTranslate->paragraph_words), $this->translationBook->original_language, $this->translationBook->translation_language, $this->isReal), JSON_UNESCAPED_UNICODE);
        $translationParagraph->sentences = json_encode(\App\TranslationBrain::translateSentences(json_decode($this->paragraphToTranslate->paragraph_sentences), $this->translationBook->original_language, $this->translationBook->translation_language, $this->isReal), JSON_UNESCAPED_UNICODE);
        $translationParagraph->original_paragraph = $this->paragraphToTranslate->id;
        $translationParagraph->original_book = $this->originalBook->id;
        $translationParagraph->translated_book = $this->translationBook->id;
        $translationParagraph->translation_language = $this->translationBook->translation_language;
        $translationParagraph->grammar = $translationParagraph->words;
        $translationParagraph->part = $this->paragraphToTranslate->part;
        $translationParagraph->chapter = $this->paragraphToTranslate->chapter;
        $translationParagraph->paragraph = $this->paragraphToTranslate->paragraph;
        $translationParagraph->paragraph_count = $this->paragraphToTranslate->paragraph_count;
        
        if(!$translationParagraph->save()) {
            
            $saved = false;
            
            // Trying to not throw away money.
            for($i = 0; $i < 5 && !$saved; $i++) {
                
                $saved = $saved || $translationParagraph->save();
                
            } 
            
            if(!$saved) {
                
                throw new \Exception('Failed to save translation!');
                
            }
            
        }
        
        // The increment below does not update the model. It cannot be used to check the value afterwards.
        // It is thread safe though, and correctly handles locking the table to change the value. (so multiple queue workers is okay)
        $this->translationBook->increment('translation_progress'); 

    }
}
