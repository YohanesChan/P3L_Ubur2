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

Route::POST('sms','TLayananController@sms');
Route::POST('pegawai/login','PegawaiController@login');

Route::GET('pegawai','PegawaiController@index');
Route::POST('pegawai/create','PegawaiController@tambah_pegawai');
Route::GET('pegawai/search/{nama_pegawai}','PegawaiController@cari_pegawai');
Route::POST('pegawai/update/{id_pegawai}','PegawaiController@edit_pegawai');
Route::POST('pegawai/delete/{id_pegawai}','PegawaiController@hapus_pegawai');

Route::GET('supplier','SupplierController@index');
Route::POST('supplier/create','SupplierController@tambah_supplier');
Route::GET('supplier/search/{nama_supplier}','SupplierController@cari_supplier');
Route::POST('supplier/update/{id_supplier}','SupplierController@edit_supplier');
Route::POST('supplier/delete/{id_supplier}','SupplierController@hapus_supplier');

Route::GET('customer','CustomerController@index');
Route::POST('customer/create','CustomerController@tambah_customer');
Route::GET('customer/search/{nama_customer}','CustomerController@cari_customer');
Route::POST('customer/update/{id_customer}','CustomerController@edit_customer');
Route::POST('customer/delete/{id_customer}','CustomerController@hapus_customer');

Route::GET('jenishwn','JenisHwnController@index');
Route::POST('jenishwn/create','JenisHwnController@tambah_jenisHwn');
Route::GET('jenishwn/search/{nama_jenis}','JenisHwnController@cari_jenisHwn');
Route::POST('jenishwn/update/{id_jenis}','JenisHwnController@edit_jenisHwn');
Route::POST('jenishwn/delete/{id_jenis}','JenisHwnController@hapus_jenisHwn');

Route::GET('ukuranhwn','UkuranHwnController@index');
Route::POST('ukuranhwn/create','UkuranHwnController@tambah_ukuranHwn');
Route::GET('ukuranhwn/search/{nama_ukuran}','UkuranHwnController@cari_ukuranHwn');
Route::POST('ukuranhwn/update/{id_ukuran}','UkuranHwnController@edit_ukuranHwn');
Route::POST('ukuranhwn/delete/{id_ukuran}','UkuranHwnController@hapus_ukuranHwn');


Route::GET('hewan','HewanController@index');
Route::POST('hewan/create','HewanController@tambah_hewan');
Route::GET('hewan/search/{nama_hewan}','HewanController@cari_hewan');
Route::POST('hewan/update/{id_hewan}','HewanController@edit_hewan');
Route::POST('hewan/delete/{id_hewan}','HewanController@hapus_hewan');

Route::GET('produk','ProdukController@index');
Route::GET('produk/notif','ProdukController@notifikasi');
Route::GET('produk/sPriceA','ProdukController@sortByPriceAsc');
Route::GET('produk/sPriceD','ProdukController@sortByPriceDesc');
Route::GET('produk/sStockA','ProdukController@sortByStockAsc');
Route::GET('produk/sStockD','ProdukController@sortByStockDesc');
Route::POST('produk/create','ProdukController@tambah_produk');
Route::GET('produk/search/{nama_produk}','ProdukController@cari_produk');
Route::POST('produk/update/{id_produk}','ProdukController@edit_produk');
Route::POST('produk/delete/{id_produk}','ProdukController@hapus_produk');

Route::GET('layanan','LayananController@index');
Route::POST('layanan/create','LayananController@tambah_layanan');
Route::GET('layanan/search/{nama_layanan}','LayananController@cari_layanan');
Route::POST('layanan/update/{id_layanan}','LayananController@edit_layanan');
Route::POST('layanan/delete/{id_layanan}','LayananController@hapus_layanan');

Route::GET('pengadaan','PengadaanController@index');
Route::POST('pengadaan/create','PengadaanController@tambah_pengadaan');
Route::POST('pengadaan/udt/{id_pengadaan}','PengadaanController@UpdateJmlProduk');
Route::POST('pengadaan/ttl/{id_pengadaan}','PengadaanController@total_pengadaan');
Route::GET('pengadaan/total/{id_pengadaan}','PengadaanController@getTotal');
Route::GET('pengadaan/search/{nama_pengadaan}','PengadaanController@cari_pengadaan');
Route::POST('pengadaan/update/{id_pengadaan}','PengadaanController@edit_pengadaan');
Route::POST('pengadaan/delete/{id_pengadaan}','PengadaanController@hapus_pengadaan');

Route::GET('detilP/{id_pengadaan_fk}','DetilPengadaanController@index');
Route::POST('detilP/create','DetilPengadaanController@tambah_detilP');
Route::GET('detilP/search/{nama_produk}','DetilPengadaanController@cari_detilP');
Route::POST('detilP/update/{id_detil_pengadaan}','DetilPengadaanController@edit_detilP');
Route::POST('detilP/delete/{id_detil_pengadaan}','DetilPengadaanController@hapus_detilP');

Route::GET('tproduk','TProdukController@index');
Route::POST('tproduk/create','TProdukController@tambah_tproduk');
Route::POST('tproduk/ttl/{id_tproduk}','TProdukController@total_tproduk');
Route::GET('tproduk/search/{nama_pengadaan}','TProdukController@cari_tproduk');
Route::POST('tproduk/update/{id_tproduk}','TProdukController@edit_tproduk');
Route::POST('tproduk/delete/{id_tproduk}','TProdukController@hapus_tproduk');

Route::GET('detilPP/{id_tproduk_fk}','DetilPPController@index');
Route::POST('detilPP/create','DetilPPController@tambah_detilPp');
Route::GET('detilPP/search/{nama_produk}','DetilPPController@cari_detilPp');
Route::POST('detilPP/update/{id_pproduk}','DetilPPController@edit_detilPp');
Route::POST('detilPP/delete/{id_pproduk}','DetilPPController@hapus_detilPp');

Route::GET('tlayanan','TLayananController@index');
Route::GET('tlayanan/finish','TLayananController@index_onfinish');
Route::GET('tlayanan/proccess','TLayananController@index_onproccess');
Route::POST('tlayanan/create','TLayananController@tambah_tlayanan');
Route::POST('tlayanan/ttl/{id_tlayanan}','TLayananController@total_tlayanan');
Route::GET('tlayanan/search/{nama_tlayanan}','TLayananController@cari_tlayanan');
Route::POST('tlayanan/update/{id_tlayanan}','TLayananController@edit_tlayanan');
Route::POST('tlayanan/delete/{id_tlayanan}','TLayananController@hapus_tlayanan');

Route::GET('detilPL/{id_playanan_fk}','DetilPLController@index');
Route::POST('detilPL/create','DetilPLController@tambah_detilPl');
Route::GET('detilPL/search/{nama_layanan}','DetilPLController@cari_detilPl');
Route::POST('detilPL/update/{id_playanan}','DetilPLController@edit_detilPl');
Route::POST('detilPL/delete/{id_playanan}','DetilPLController@hapus_detilPl');
