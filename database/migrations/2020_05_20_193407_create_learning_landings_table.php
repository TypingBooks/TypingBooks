<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLearningLandingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('learning_landings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title');
            $table->text('data')->nullable();
            $table->unsignedBigInteger('native_lang');
            $table->foreign('native_lang')->references('id')->on('languages');
            $table->unsignedBigInteger('learning_lang');
            $table->foreign('learning_lang')->references('id')->on('languages');
            
            $table->index(['native_lang', 'learning_lang']);
            
            //ALTER TABLE `homestead`.`learning_landings` ADD INDEX `normal_lookup` (`native_lang`, `learning_lang`);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('learning_landings');
    }
}
