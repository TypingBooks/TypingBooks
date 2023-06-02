<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDictionaryItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dictionary_items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('from_language');
            $table->foreign('from_language')->references('id')->on('languages');
            $table->unsignedBigInteger('to_language');
            $table->foreign('to_language')->references('id')->on('languages');
            $table->string('word')->collation('utf8mb4_bin');
            $table->string('translation')->collation('utf8mb4_bin');
            
            $table->index(['from_language', 'to_language', 'word']);
            //ALTER TABLE `homestead`.`dictionary_items` ADD INDEX `lookup` (`from_language`, `to_language`, `word`);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dictionary_items');
    }
}
