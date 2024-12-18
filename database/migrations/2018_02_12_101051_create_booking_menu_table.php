<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_menu', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('menu_id');
            $table->unsignedInteger('tour_id');
            $table->unique(['menu_id', 'tour_id']);
            $table->integer('quantity')->default(0);
            $table->timestamps();

            $table->foreign('menu_id')->references('id')->on('menu');
            $table->foreign('tour_id')->references('id')->on('tours');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_menu');
    }
}
