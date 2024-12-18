<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateToursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->increments('id');
            //$table->string('name');
            $table->date('date');
            $table->time('starting_time');
            $table->dateTime('tour_time');
            $table->integer('price');
            $table->integer('capacity')->default(16);
            $table->enum('status', ['pending', 'running', 'finished', 'canceled'])->default('pending');
            $table->unsignedInteger('guide_id')->nullable();
            $table->timestamps();

            $table->foreign('guide_id')->references('id')->on('guides');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tours');
    }
}
