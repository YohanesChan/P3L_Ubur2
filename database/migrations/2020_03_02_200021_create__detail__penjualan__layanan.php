<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPenjualanLayanan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Detil_P_Layanans', function (Blueprint $table) {
            $table->bigIncrements('id_penjualan_layanan'); // no transaksi_layanan
            $table->string('kode_penjualan_layanan')->nullable();
            $table->dateTime('tgl_penjualan_layanan')->nullable();
            $table->integer('jml_penjualan_layanan')->nullable();
            $table->float('subtotal_penjualan_layanan')->nullable();
            $table->string('status_layanan')->nullable();

            $table->unsignedBigInteger('id_pegawai_fk');
            $table->foreign('id_pegawai_fk')->references('id_pegawai')->on('Pegawais');
            $table->unsignedBigInteger('id_layanan_fk'); 
            $table->foreign('id_layanan_fk')->references('id_layanan')->on('Layanans');
            $table->unsignedBigInteger('id_transaksi_fk'); // no transaksi
            $table->foreign('id_transaksi_fk')->references('id_transaksi')->on('Transaksis');
            $table->unsignedBigInteger('id_hewan_fk');
            $table->foreign('id_hewan_fk')->references('id_hewan')->on('Hewans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Detail_Penjualan_Layanans');
    }
}
