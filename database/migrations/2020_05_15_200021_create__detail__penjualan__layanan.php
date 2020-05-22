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
            $table->bigIncrements('id_playanan');;
            $table->string('nama_layanan')->nullable();
            $table->integer('jml_layanan')->nullable();
            $table->float('harga_layanan')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
            
            $table->bigInteger('id_tlayanan_fk')->unsigned();
            $table->foreign('id_tlayanan_fk')->references('id_tlayanan')->on('t_layanans');
            $table->unsignedBigInteger('id_layanan_fk');
            $table->foreign('id_layanan_fk')->references('id_layanan')->on('Layanans');
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
