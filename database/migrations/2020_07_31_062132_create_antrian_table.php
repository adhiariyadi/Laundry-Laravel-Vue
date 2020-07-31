<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAntrianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antrian', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('member_id');
            $table->timestamp('selesai')->nullable();
            $table->timestamp('ambil')->nullable();
            $table->enum('pembayaran', ['pending', 'selesai']);
            $table->unsignedBigInteger('operator');
            $table->enum('status', ['hold', 'cuci', 'selesai']);
            $table->timestamps();

            $table->foreign('member_id')->references('id')->on('member');
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
        Schema::dropIfExists('antrian');
    }
}
