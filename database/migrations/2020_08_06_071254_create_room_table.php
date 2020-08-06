<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('antrian_id');
            $table->integer('total')->nullable();
            $table->unsignedBigInteger('operator');
            $table->enum('status', ['ready', 'cuci', 'selesai']);
            $table->timestamps();

            $table->foreign('antrian_id')->references('id')->on('antrian');
            $table->foreign('operator')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('room');
    }
}
