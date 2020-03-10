<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Produks', function (Blueprint $table) {
            $table->bigIncrements('id_produk');
            $table->string('nama_produk')->nullable();
            $table->integer('harga_produk')->nullable();
            $table->string('image_produk')->nullable();
            $table->integer('stok_produk')->nullable();
            $table->integer('stok_minimal')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
         

            $table->unsignedBigInteger('id_pegawai_fk');
            $table->foreign('id_pegawai_fk')->references('id_pegawai')->on('Pegawais');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Produks');
    }
}
