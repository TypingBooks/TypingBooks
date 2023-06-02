<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParagraphTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paragraph_translations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('words', 25000);
            $table->text('sentences', 25000);
            $table->unsignedBigInteger('original_paragraph');
            $table->foreign('original_paragraph')->references('id')->on('paragraphs');
            $table->unsignedBigInteger('translation_language');
            $table->foreign('translation_language')->references('id')->on('languages');
            $table->unsignedBigInteger('original_book');
            $table->unsignedBigInteger('translated_book');
            $table->foreign('original_book')->references('id')->on('books');
            $table->foreign('translated_book')->references('id')->on('book_translations');
            $table->text('grammar', 25000)->nullable();
            $table->integer('paragraph');
            $table->integer('paragraph_count');
            $table->integer('part');
            $table->integer('chapter');
            
            // Common sort
            $table->index(['translated_book', 'paragraph_count']);
            
            // Actual order found in books
            $table->index(['translated_book', 'part', 'chapter', 'paragraph'], 'actual_order');
            //ALTER TABLE `homestead`.`paragraphs` ADD INDEX `game_lookup` (`book`, `paragraph_count`);
            //ALTER TABLE `homestead`.`paragraphs` ADD UNIQUE `normal_order` (`book`, `part`, `chapter`, `paragraph`);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paragraph_translations');
    }
}
