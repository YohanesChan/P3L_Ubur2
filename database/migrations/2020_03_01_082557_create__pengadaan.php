<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengadaan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Pengadaans', function (Blueprint $table) {
            $table->bigIncrements('id_pengadaan');
            $table->string('kode_pengadaan')->nullable();
            $table->string('nama_produk')->nullable();
            $table->string('status_PO')->nullable();
            $table->dateTime('tgl_pengadaan')->nullable();
            $table->float('subtotal_pengadaan')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
          

            $table->unsignedBigInteger('id_pegawai_fk');
            $table->foreign('id_pegawai_fk')->references('id_pegawai')->on('Pegawais');
            $table->unsignedBigInteger('id_supplier_fk');
            $table->foreign('id_supplier_fk')->references('id_supplier')->on('Suppliers');
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
        Schema::dropIfExists('Pengadaans');
    }
}
