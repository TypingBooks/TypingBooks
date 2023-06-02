<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDictionariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dictionaries', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('landing');
            $table->foreign('landing')->references('id')->on('learning_landings');
            $table->unsignedBigInteger('from_language');
            $table->foreign('from_language')->references('id')->on('languages');
            $table->unsignedBigInteger('to_language');
            $table->foreign('to_language')->references('id')->on('languages');
            $table->text('json_file')->nullable();
            $table->boolean('file_needs_update')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dictionaries');
    }
}
