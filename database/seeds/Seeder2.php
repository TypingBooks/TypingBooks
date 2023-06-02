<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class Seeder2 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $this->call(AddGlobalSettings::class);
        $this->call(AddAllLanguages::class);
        $this->call(TempAddAllBooks::class);  
        $this->call(TestUser::class);
        //$this->call(MigrateLegacyBooks::class); // run after books finish importing.
    }
}
