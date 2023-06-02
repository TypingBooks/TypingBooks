<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title', 50);
            $table->unsignedBigInteger('language');
            $table->foreign('language')->references('id')->on('languages');
            $table->string('location');
            $table->string('author')->nullable();
            $table->integer('amount_of_paragraphs')->nullable();
            $table->integer('characters')->nullable();
            $table->integer('characters_in_words')->nullable();
            
            $table->boolean('is_active')->default(1);
            
            $table->index('language');
            $table->index('title');
            
            //ALTER TABLE `homestead`.`books` ADD INDEX `common_sort` (`language`);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
