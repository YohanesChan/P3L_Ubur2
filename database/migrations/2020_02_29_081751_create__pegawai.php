<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePegawai extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Pegawais', function (Blueprint $table) {
            $table->bigIncrements('id_pegawai');
            $table->string('no_pegawai');
            $table->string('nama_pegawai')->nullable();
            $table->integer('role_pegawai')->nullable();
            $table->string('alamat_pegawai')->nullable();
            $table->date('birthday_pegawai')->nullable();
            $table->string('telp_pegawai')->nullable();
            $table->string('username_pegawai')->unique();
            $table->string('password_pegawai')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();

            // $table->primary('id_pegawai');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Pegawais');
    }
}
