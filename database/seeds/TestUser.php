<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\TestResult;

class TestUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $testUser = new \App\User();
        
        $testUser->password = Hash::make('password');
        $testUser->name = '-----';
        $testUser->email = 'admin@adminc.com';
        $testUser->rank = 'admin';
        $testUser->save();
        
        /* 
        // create some data for the charts in profile
        
        for($i = 1; $i <= 10; $i++) {
            
            $r = new TestResult();
            $r->paragraph = 1;
            $r->wpm = rand(1, 120) + (rand(0, 100) / 100);
            $r->paragraph = 1;
            $r->translation_paragraph = 1;
            $r->user = 1;
            $r->book_translation = 1;
            
            $r->save();
            
        }
        */
            
    }
}
