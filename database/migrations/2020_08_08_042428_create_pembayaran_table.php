<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePembayaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('invoice');
            $table->unsignedBigInteger('antrian_id');
            $table->timestamp('waktu')->nullable();
            $table->integer('jumlah_cuci');
            $table->integer('harga');
            $table->integer('discount');
            $table->integer('total');
            $table->integer('bayar');
            $table->integer('kembali');
            $table->enum('payment_method', ['Uang Cash']);
            $table->unsignedBigInteger('operator');
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
        Schema::dropIfExists('pembayaran');
    }
}
