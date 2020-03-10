<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::GET('pegawai','PegawaiController@index');
Route::POST('pegawai/create','PegawaiController@tambah_pegawai');
Route::GET('pegawai/search/{nama_pegawai}','PegawaiController@cari_pegawai');
Route::POST('pegawai/update/{id_pegawai}','PegawaiController@edit_pegawai');
Route::POST('pegawai/delete/{id}','PegawaiController@hapus_pegawai');

Route::GET('supplier','SupplierController@index');
Route::POST('supplier/create','SupplierController@tambah_supplier');
Route::GET('supplier/search/{nama_supplier}','SupplierController@cari_supplier');
Route::POST('supplier/update/{id_supplier}','SupplierController@edit_supplier');
Route::POST('supplier/delete/{id}','SupplierController@hapus_supplier');