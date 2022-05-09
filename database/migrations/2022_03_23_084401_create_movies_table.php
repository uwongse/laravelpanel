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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->longText('synopsis')->nullable();
            $table->integer('duration')->nullable();
            $table->date('date')->nullable();
            $table->string('trailer')->nullable();
            $table->string('type')->nullable();
            $table->date('premiere')->nullable();
            $table->string('buy')->nullable();
            $table->tinyInteger('active')->default('1')->nullable();
            $table->tinyInteger('update')->default('0')->nullable();
            $table->bigInteger('qualification_id')->unsigned();
            $table->foreign('qualification_id')->references('id')->on('qualifications');
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
        Schema::dropIfExists('movies');
    }
};
