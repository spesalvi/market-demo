<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGiftCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gift_cards', function (Blueprint $table) {
            $table->increments('id');
	    $table->string('card_number');
	    $table->string('encyrpted_pin');
	    $table->decimal('balance', 9, 2);
	    $table->date('expiry_date');
	    $table->decimal('offer_price', 9, 2);
	    $table->integer('user_id')->unsigned();
	    $table->integer('brand_id');
            $table->timestamps();

	    $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('gift_cards');
    }
}
