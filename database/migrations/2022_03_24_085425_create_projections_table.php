<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projections', function (Blueprint $table) {
            $table->id();
            $table->string('hour')->nullable();
            $table->string('release_date')->nullable();
            $table->bigInteger('movie_id')->unsigned();
            $table->bigInteger('room_id')->unsigned();
            $table->bigInteger('cinema_id')->unsigned();
            $table->bigInteger('syncronitation_id')->unsigned();
            $table->foreign('movie_id')->references('id')->on('movies');
            $table->foreign('room_id')->references('id')->on('rooms');
            $table->foreign('cinema_id')->references('id')->on('cinemas');
            $table->foreign('syncronitation_id')->references('id')->on('syncronitations');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projections');
    }
};
