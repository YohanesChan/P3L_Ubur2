<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPengadaan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Detail_Pengadaans', function (Blueprint $table) {
            $table->bigIncrements('id_detil_pengadaan');
            $table->integer('jml_produk')->nullable();
            $table->float('totalHarga_pengadaan')->nullable();
           

            $table->bigInteger('id_pengadaan_fk')->unsigned();
            $table->foreign('id_pengadaan_fk')->references('id_pengadaan')->on('Pengadaans');
            $table->unsignedBigInteger('id_produk_fk');
            $table->foreign('id_produk_fk')->references('id_produk')->on('Produks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Detail_Pengadaans');
    }
}
