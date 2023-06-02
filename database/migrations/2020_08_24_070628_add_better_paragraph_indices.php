<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBetterParagraphIndices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('paragraphs', function (Blueprint $table) {
            
            $table->unsignedBigInteger('parent_index')->nullable();
            $table->foreign('parent_index')->references('id')->on('book_indices');
            $table->integer('test_group')->nullable();
            $table->integer('order_in_test_group')->nullable();
            $table->integer('order_in_section')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paragraphs', function (Blueprint $table) {
            //
        });
    }
}
