<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLanguageToTestResults extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('test_results', function (Blueprint $table) {
            
            $table->unsignedBigInteger('language')->nullable();
            $table->foreign('language')->references('id')->on('languages');
            
            $table->unsignedBigInteger('book')->nullable();
            $table->foreign('book')->references('id')->on('books');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('test_results', function (Blueprint $table) {
            //
        });
    }
}
