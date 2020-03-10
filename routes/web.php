<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::GET('pegawai','PegawaiController@index');
Route::POST('pegawai','PegawaiController@tambah_pegawai');
Route::GET('pegawai/{nama_pegawai}','PegawaiController@cari_pegawai');
Route::POST('pegawai/{id_pegawai}','PegawaiController@edit_pegawai');
Route::POST('pegawai/{id}','PegawaiController@hapus_pegawai');
