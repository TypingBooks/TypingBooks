<?php

namespace App\Console;

use App\Dictionary;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\UpdateBookJsonFile;
use App\Jobs\UpdateBookPricing;
use App\Jobs\UpdateDataArchive;
use App\Jobs\UpdateDictionaryFile;
use App\BookTranslation;
use Illuminate\Support\Facades\App;
use App\Jobs\ValidateBookTranslation;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // The tasks below shouldn't actually need this much time
        // as most of the work to be completed is done in queues
        // but it's probably a decent idea to make sure this doesn't 
        // time out
        set_time_limit(300);
        
        $schedule->call(function () {
            
            $booksThatNeedJsonFiles = BookTranslation::where('has_translation', '=', true)->where('json_file', '=', null)->get();
            
            foreach($booksThatNeedJsonFiles as $bookNeedingJson) {
                
                // Only create the JSON file if the book has finished being translated
                // otherwise, it'll just be pushed to the next day.
                if($bookNeedingJson->getTranslationProgress() == 100.00) {
                    
                    
                    UpdateBookJsonFile::dispatch($bookNeedingJson)->onQueue('default_long');
                    
                    // Since the book's translation is completed, that means the dictionary updates
                    // are also complete. It's time to update the dictionary json file too.
                    $dictionaryToUpdate = Dictionary::getDictionaryRelatedToBookTranslation($bookNeedingJson);
                    
                    // The dictionary and related books could have already been updated
                    // if two book translations are from the same landing/category
                    // ...I noticed this doesn't actually work because they're dispatched to
                    // a queue. I added the check there, but left it here for clarity.
                    // It might still happen anyway, because there are 8 queue workers
                    // that could trigger too closely together for the update to take place.
                    // Instead of locking the file, it's probably a better idea to just rewrite
                    // the above so that books that need json + share the same dictionary don't trigger
                    // it twice (especially because of all of pricing updates that are triggered along with it)
                    //
                    // ...but those are also problematic because they could be done with less resources if they are
                    // shared the same trie. Anyway, for now, it should be fine.
                    if($dictionaryToUpdate->file_needs_update) {
                    
                        UpdateDictionaryFile::dispatch($dictionaryToUpdate)->onQueue('default_long');
                        
                    }
                    
                }
                
            }
            
        })->hourly();
        
        $schedule->call(function() {
            
            // This just grabs all the data files that we make available,
            // zips them, replaces the current archive, and makes it available
            // for download. It currently does not check if it needs to update them 
            // (like if no changes have been made, it'll still update this archive)
            // but since it only takes one translation being purchased, it'll just be
            // updated anyway.
            UpdateDataArchive::dispatch()->onQueue('default_long')->onQueue('default_long');
            
        })->daily();
        
        
        $schedule->call(function() {
            
            $maybeErroredBooks = \App\Book::where('state', '=', 'importing')->orWhere('state', '=', 'running_replacements')->get();
            
            // Just check each book hourly to see if it failed to complete a job. If the job
            // is older than 1 hour, we will assume that the job is dead for the user. It doesn't
            // actually clear the queue, but if it does complete, it will fix error state anyway.
            foreach($maybeErroredBooks as $book) {
                
                if($book->updated_at->diffInHours(Carbon::now()) > 0) {
                    
                    $book->state = 'error';
                    
                    $book->save();
                    
                    
                }
                
            }
            
        })->hourly();
        
        $schedule->call(function() {
            
            $notFullyValidatedBooks = \App\BookTranslation::where('has_translation', '=', 1)->where('validation_errors', '!=', 0)->orWhere('validation_errors', '=', null)->where('has_translation', '=', 1)->get();
            
            foreach($notFullyValidatedBooks as $book) {
                
                ValidateBookTranslation::dispatch($book)->onQueue('default_long');
                
            }
            
        })->daily();
        
        
        // Credit to:
        // https://medium.com/@dennissmink/laravel-backup-database-to-your-google-drive-f4728a2b74bd
        // Archived: http://archive.is/Lq4Zb
        if(App::environment('production')) {
            
            $schedule->command('backup:clean')->daily()->at('01:00');
            $schedule->command('backup:run')->daily()->at('02:00');
            
        }
        
        
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
