<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPenjualanProduk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Detail_Penjualan_Produks', function (Blueprint $table) {
            $table->bigIncrements('id_penjualan_produk');
            $table->string('kode_penjualan_produk')->nullable();
            $table->dateTime('tgl_penjualan_produk')->nullable();
            $table->integer('jml_penjualan_produk')->nullablewh();
            $table->float('subtotal_penjualan_produk')->nullable();
            

            $table->unsignedBigInteger('id_pegawai_fk');
            $table->foreign('id_pegawai_fk')->references('id_pegawai')->on('Pegawais');
            $table->unsignedBigInteger('id_produk_fk');
            $table->foreign('id_produk_fk')->references('id_produk')->on('Produks');
            $table->unsignedBigInteger('id_transaksi_fk');
            $table->foreign('id_transaksi_fk')->references('id_transaksi')->on('Transaksis');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Detail_Penjualan_Produks');
    }
}
