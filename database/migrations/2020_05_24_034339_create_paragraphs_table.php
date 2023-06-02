<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParagraphsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paragraphs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            ///paragraph_content, book, part, chapter, paragraph
            $table->text('paragraph_content', 25000); 
            $table->text('paragraph_words', 25000); 
            $table->text('paragraph_sentences', 25000)->nullable();
            $table->unsignedBigInteger('book');
            $table->foreign('book')->references('id')->on('books');
            $table->integer('part');
            $table->integer('chapter');
            $table->integer('paragraph');
            $table->integer('paragraph_count');
            
            // It's actually not being looked up very often in this way.
            // It's usually by primary key only
            $table->index(['book', 'part', 'chapter', 'paragraph']);
            
            // The next two below are just in case the first index isn't used 
            // because of weird mysql rules. I should probably read mysql documentation
            $table->index(['book', 'part', 'chapter']);
            $table->index(['book', 'part']);
            
            // This is likely a more common sort order for lookups, but this 
            // table probably won't be used for this.
            $table->index(['book', 'paragraph_count']);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paragraphs');
    }
}
