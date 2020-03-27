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
        Schema::create('Detil_Pengadaans', function (Blueprint $table) {
            $table->bigIncrements('id_detil_pengadaan');
            
            $table->string('nama_produk')->nullable();
            $table->integer('jml_produk')->nullable();
            $table->integer('harga_produk')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();

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
