<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            // https://stripe.com/docs/upgrades 
            // ctrl + f "You can safely assume object IDs we generate will never exceed 255 characters"
            $table->string('stripe_session_id', 255)->collation('utf8_bin')->nullable(); 
            $table->enum('state', ['pending', 'complete'])->default('pending');
            $table->unsignedBigInteger('user')->nullable();
            $table->foreign('user')->references('id')->on('users');
            $table->unsignedBigInteger('book_translation');
            $table->foreign('book_translation')->references('id')->on('book_translations');
            
            // this is actually unique, but oh well.
            $table->index(['stripe_session_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
