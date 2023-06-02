<?php

use Illuminate\Database\Seeder;

class LandingPages extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*            
            $table->id();
            $table->timestamps();
            $table->string('title');
            $table->unsignedBigInteger('native_lang');
            $table->foreign('native_lang')->references('id')->on('languages');
            $table->unsignedBigInteger('learning_lang');
            $table->foreign('learning_lang')->references('id')->on('languages');
        */
        
        $languages = \App\Language::get();
        
        foreach($languages as $native) {
            
            foreach($languages as $learning) {
                    
                $landing = new \App\LearningLanding();
                
                $landing->title = $learning->language;
                $landing->native_lang = $native->id;
                $landing->learning_lang = $learning->id;
                
                $landing->save();
                
                $dictionary = new \App\Dictionary();
                
                $dictionary->from_language = $native->id;
                $dictionary->to_language = $learning->id;
                $dictionary->landing = $landing->id;
                
                $dictionary->save();
                
            }
            
        }
        
    }
}
