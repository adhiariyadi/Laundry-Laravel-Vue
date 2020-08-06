<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCucianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cucian', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('antrian_id');
            $table->unsignedBigInteger('category_id');
            $table->integer('harga');
            $table->integer('quantity');
            $table->integer('total');
            $table->timestamps();

            $table->foreign('antrian_id')->references('id')->on('antrian');
            $table->foreign('category_id')->references('id')->on('category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cucian');
    }
}
