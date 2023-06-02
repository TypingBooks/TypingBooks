<?php

namespace App\Jobs;

use App\Book;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Stripe\Issuing\Transaction;

class UserValidateBook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $book;
    protected $replacements;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Book $book, $replacements)
    {
        $this->book = $book;
        $this->replacements = $replacements;
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $book = $this->book;
        $replacements = $this->replacements;
        $charsNeedingReplacement = $book->getCharactersNeedingReplacement();
        
        $punctuationMap = $book->getPunctuationMap(); 
        
        if(count($charsNeedingReplacement) > 0) {
            
            foreach($replacements as $replacement) {
                
                if(isset($punctuationMap[$replacement])) {
                    
                    throw new \Exception('Do not make replacements with punctuation.');
                    
                }
                
            }
            
            foreach($charsNeedingReplacement as $replacement) {
                
                if(isset($punctuationMap[$replacement])) {
                    
                    throw new \Exception('Do not replace punctuation...');
                    
                }
                
            }
            
            if(count($charsNeedingReplacement) != count($replacements)) {
                
                throw new \Exception('Replacements does not equal characters needing replacement...');
                
            }
            
            DB::transaction(function () use ($book, $replacements, $charsNeedingReplacement) {
                
                $replacementsNeeded = count($charsNeedingReplacement);
                
                $punctuationMap = $book->getPunctuationMap();
                
                for($i = 0; $i < $replacementsNeeded; $i++) {
                    
                    $book->replaceInBook($charsNeedingReplacement[$i], $replacements[$i], false, $punctuationMap);
                    
                }
                
                
            });
            
        }
        
        $book->passed_validation_by_user = true;
        $book->state = 'live';
        
        if(!$book->save()) {
            
            throw new \Exception('Failed to update that this book passed validation.');
            
        }
        
        if(config('app.debug') == false && !$book->is_private) {
            
            SendDiscordMessage::dispatch($book->getDiscordMessage(), '');
            
        }
    }
}
