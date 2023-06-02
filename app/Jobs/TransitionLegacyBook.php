<?php

namespace App\Jobs;

use App\Book;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class TransitionLegacyBook implements ShouldQueue
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
        $book = $this->book;
        
        DB::transaction(function() use ($book) {
            
            $book->passed_validation_by_user = true;
            $book->added_by = 1;
            $book->state = 'live';
            
            if(!$book->save()) {
                
                throw new \Exception('failed to update the user..');
                
            }
            
            $partsInBook = $book->getAmountOfParts();
            
            $total = 0;
            
            for($i = 1; $i <= $partsInBook; $i++) {
                
                $chaptersInPart = $book->getAmountOfChaptersInPart($i);
                
                $bookIndex = new \App\BookIndex();
                $bookIndex->title = 'Part ' . $i;
                $bookIndex->book = $book->id;
                $bookIndex->order = ($i - 1);
                
                if(!$bookIndex->save()) {
                    
                    throw new \Exception('failed to create an index for a part.');
                    
                }
                
                $chapterOrder = 0;
                
                for($j = 1; $j <= $chaptersInPart; $j++) {
                    
                    $chapterIndex = new \App\BookIndex();
                    
                    $chapterIndex->title = 'Chapter ' . $j;
                    $chapterIndex->book = $book->id;
                    $chapterIndex->parent = $bookIndex->id;
                    $chapterIndex->order = $chapterOrder;
                    $chapterOrder++;
                    
                    if(!$chapterIndex->save()) {
                        
                        throw new \Exception('failed to create a chapter for a part.');
                        
                    }
                    
                    $paragraphsInChapter = $book->getAmountOfParagraphsInChapter($i, $j);
                    
                    for($k = 1; $k <= $paragraphsInChapter; $k++) {
                        
                        $paragraphToMigrate = \App\Paragraph::where('book', '=', $book->id)->where('part', '=', $i)->where('chapter', '=', $j)->where('paragraph', '=', $k)->first();
                        
                        $paragraphToMigrate->parent_index = $chapterIndex->id;
                        $paragraphToMigrate->test_group = $total;
                        $paragraphToMigrate->order_in_test_group = 0;
                        $paragraphToMigrate->order_in_section = ($k - 1);
                        
                        if(!$paragraphToMigrate->save()) {
                            
                            throw new \Exception('failed to migrate a paragraph.');
                            
                        }
                        
                        $total++;
                        
                    }
                    
                }
                
            }
            
            if($total != \App\Paragraph::where('book', '=', $book->id)->count()) {
                
                throw new \Exception('not all paragraphs were migrated..');
                
            }
            
            
        });
        
        
        
    }
}
