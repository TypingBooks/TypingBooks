<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraBookSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->unsignedBigInteger('added_by')->nullable(1);
            $table->foreign('added_by')->references('id')->on('users');
            $table->boolean('is_private')->default(0);
            
            // live just means that there are no errors and it is passed validation
            // validation means the user needs to replace characters that were not in whitelists
            $table->enum('state', ['importing', 'error', 'validation', 'running_replacements', 'live'])->default('importing');
            
            $table->boolean('passed_validation_by_user')->default(0);
            
            $table->text('characters_needing_replacement', 25000);
            $table->text('replacements_user_defined', 25000)->nullable('[]');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('books', function (Blueprint $table) {
            //
        });
    }
}
