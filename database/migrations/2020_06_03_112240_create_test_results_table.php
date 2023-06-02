<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_results', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->decimal('wpm', 6, 2);
            $table->unsignedBigInteger('paragraph');
            $table->foreign('paragraph')->references('id')->on('paragraphs');
            $table->unsignedBigInteger('translation_paragraph'); // this is used for logging which version a user is using
            $table->foreign('translation_paragraph')->references('id')->on('paragraph_translations');
            $table->unsignedBigInteger('user');
            $table->foreign('user')->references('id')->on('users');
            
            // Since I included all of these... it probably would have been smart to include the original book.
            // The book translation isn't really too useful...
            $table->unsignedBigInteger('book_translation'); 
            $table->foreign('book_translation')->references('id')->on('book_translations');
            
            $table->index(['created_at']);
            
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_results');
    }
}
