<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_translations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('book');
            $table->unsignedBigInteger('translation_language');
            $table->foreign('book')->references('id')->on('books');
            $table->foreign('translation_language')->references('id')->on('languages');
            $table->unsignedBigInteger('learning_landing');
            $table->foreign('learning_landing')->references('id')->on('learning_landings');
            $table->boolean('has_translation')->default(0);
            $table->unsignedBigInteger('original_language');
            $table->foreign('original_language')->references('id')->on('languages');
            $table->integer('translation_progress')->default(0);
            $table->integer('characters_not_in_dictionary')->nullable();
            
            // Side by side sentence translations encoded in json.
            // It's done this way because json is an extremely common encoding which 
            // many languages support without much configuration. It limits the amount
            // of time that someone will waste trying to parse the data.
            $table->text('json_file')->nullable();
            
            $table->integer('validation_errors')->nullable();
            
            $table->boolean('is_active')->default(1);
            
            // common lookup - this table isn't very large so it shouldn't matter
            // Identifier name 'book_translations_has_translation_original_language_translation_language_index' is too long
            // lol
            $table->index(['is_active', 'has_translation', 'original_language', 'translation_language'], 'common_lookup');
            
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_translations');
    }
}
