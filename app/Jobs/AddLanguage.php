<?php

namespace App\Jobs;

use App\Book;
use App\Language;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\LearningLanding;
use Illuminate\Support\Facades\DB;

class AddLanguage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $language;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Language $language)
    {
        $this->language = $language;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        set_time_limit(10000);
        
        $thisLanguage = $this->language;
        $languages = Language::where('id', '!=', $this->id)->get();
        
        DB::transaction(function () use ($thisLanguage, $languages) {
        
            foreach($languages as $otherLanguage) {
                
                $l1 = new \App\LearningLanding();
                $l2 = new \App\LearningLanding();
                
                $l1->native_lang = $thisLanguage->id;
                $l1->learning_lang = $otherLangage->id;
                
                $l2->native_lang = $otherLangage->id;
                $l2->learning_lang = $thisLanguage->id;
                
                if(!($l1->save() && $l2->save())) {
                    
                    throw new \Exception('Failed to create landings');
                    
                }
                
                $dictionary1 = new \App\Dictionary();
                
                $dictionary1->from_language = $thisLanguage->id;
                $dictionary1->to_language = $otherLangage->id;
                $dictionary1->landing = $l1->id;
                
                $dictionary2 = new \App\Dictionary();
                
                $dictionary2->from_language = $otherLangage->id;
                $dictionary2->to_language = $thisLanguage->id;
                $dictionary2->landing = $l2->id;
                
                if(!($dictionary1->save() && $dictionary2->save())) {
                    
                    throw new \Exception('Failed to create dictionary');
                    
                }
                
                $booksInOtherLanguage = \App\Book::where('language', '=', $otherLanguage->id)->get();
                
                foreach($booksInOtherLanguage as $book) {
                    
                    if(!$book->createBaseTranslationBook($thisLanguage, $l2)) {
                        
                        throw new \Exception('Failed to create a base translation for a book.');
                        
                    }
                    
                }
                
            }
        });
    }
}
