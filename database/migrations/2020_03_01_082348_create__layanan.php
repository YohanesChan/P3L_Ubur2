<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLayanan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Layanans', function (Blueprint $table) {
            $table->bigIncrements('id_layanan');
            $table->string('nama_layanan')->nullable();
            $table->integer('harga_layanan')->nullable();
            $table->string('image_layanan')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
           

            $table->unsignedBigInteger('id_pegawai_fk');
            $table->foreign('id_pegawai_fk')->references('id_pegawai')->on('Pegawais');
            $table->unsignedBigInteger('id_ukuran_fk');
            $table->foreign('id_ukuran_fk')->references('id_ukuran')->on('Ukuran_Hewans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Layanans');
    }
}
