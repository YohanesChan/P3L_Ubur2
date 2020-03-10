<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Customers', function (Blueprint $table) {
            $table->bigIncrements('id_customer');
            $table->string('nama_customer')->nullable();
            $table->string('alamat_customer')->nullable();
            $table->date('birthday_customer')->nullable();
            $table->string('telp_customer')->nullable();
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
        Schema::dropIfExists('Customers');
        Schema::enableForeignKeyConstraints();
    }
}
