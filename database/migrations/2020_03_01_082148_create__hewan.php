<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHewan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Hewans', function (Blueprint $table) {
            $table->bigIncrements('id_hewan');
            $table->string('nama_hewan')->nullable();
            $table->string('no_hewan')->nullable();
            $table->date('birthday_hewan')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
          

            $table->unsignedBigInteger('id_customer_fk');
            $table->foreign('id_customer_fk')->references('id_customer')->on('Customers');
            $table->unsignedBigInteger('id_pegawai_fk');
            $table->foreign('id_pegawai_fk')->references('id_pegawai')->on('Pegawais');
            $table->unsignedBigInteger('id_jenis_fk');
            $table->foreign('id_jenis_fk')->references('id_jenis')->on('Jenis_Hewans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Hewans');
    }
}

