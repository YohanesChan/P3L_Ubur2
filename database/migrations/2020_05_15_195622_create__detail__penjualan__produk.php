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
        Schema::create('Detil_P_Produks', function (Blueprint $table) {
            $table->bigIncrements('id_pproduk');;
            $table->string('nama_produk')->nullable();
            $table->integer('jml_produk')->nullable();
            $table->float('harga_produk')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
            
            $table->bigInteger('id_tproduk_fk')->unsigned();
            $table->foreign('id_tproduk_fk')->references('id_tproduk')->on('t_produks');
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
        Schema::dropIfExists('Detail_Penjualan_Produks');
    }
}
