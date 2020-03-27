<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Transaksis', function (Blueprint $table) {
            $table->bigIncrements('id_transaksi');
            $table->string('kode_transaksi')->nullable();
            $table->dateTime('tgl_transaksi')->nullable();
            $table->float('diskon_transaksi')->nullable();
            $table->float('total_transaksi')->nullable();
            $table->string('status_transaksi')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();

            $table->unsignedBigInteger('id_pegawai_fk');
            $table->foreign('id_pegawai_fk')->references('id_pegawai')->on('Pegawais');
            $table->unsignedBigInteger('id_customer_fk');
            $table->foreign('id_customer_fk')->references('id_customer')->on('Customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Transaksis');
    }
}
