<?php

use Illuminate\Database\Seeder;

class AddGlobalSettings extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = new \App\Settings();
        
        $settings->type = 'default';
        $settings->gloabl_whitelisted_characters = '?! .';
        $settings->global_replace_characters = '';
        $settings->global_punctuation_characters = '?!.';
        
        $settings->save();
        
    }
}
