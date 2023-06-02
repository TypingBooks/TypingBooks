<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        $this->call(AddGlobalSettings::class);
        // Most jobs will always be fine... And if they won't, they'll usually be a queue job.
        // Users can't trigger these types of jobs that will cause the memory use to be high.
        ini_set('memory_limit','2048M'); 
        
        $this->call(Languages::class);
        $this->call(LandingPages::class);
        
        //$ redis-cli
        //127.0.0.1:6379> FLUSHDB
        // php artisan migrate:fresh
        // php artisan db:seed --class Seeder2
        // or
        // php artisan db:seed --class AddAllLanguages
        // php artisan db:seed --class TempAddAllBooks
        
        // It should be seeded only once for production, and not automatically.
        if (!App::environment('production')) {
            
            $this->call(AddBook::class);
            
        }
        
        $this->call(TestUser::class); //test@test.com - password
        
        //$this->call(MigrateLegacyBooks::class); // run after books finish importing.
    }
}
