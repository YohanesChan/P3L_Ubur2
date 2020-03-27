<?php

namespace App\Http\Controllers;
use App\DetilPProduk;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DetilPPController extends Controller
{
    public function index()
    {
        $detilPP = DetilPProduk::all();
        $response = [
            'status' => 'GET Berhasil',
            'result' => $detilPP,
        ];

        return response()->json($response,200);
    }

    public function tambah_detilPP(Request $request)
    {
        $detilPP = new DetilPProduk();
        $detilPP->kode_penjualan_produk = $request['kode_penjualan_produk'];
        $detilPP->tgl_penjualan_produk = $request['tgl_penjualan_produk'];
        $detilPP->jml_penjualan_produk = $request['jml_penjualan_produk'];
        $detilPP->subtotal_penjualan_produk = $request['subtotal_penjualan_produk'];
        $detilPP->id_pengadaan_fk = 1;
        $detilPP->id_produk_fk = 1;
        $detilPP->id_transaksi_fk = 1;
        $detilPP->created_at = Carbon::now();
        $detilPP->updated_at = Carbon::now();
        try{
            $success = $detilPP->save();
            $status = 200;
            $response = [
                'status' => 'Input Berhasil',
                'result' => $detilPP
            ];
            
        }catch(\Illuminate\Database\QueryException $e){
            $status = 500;
            $response = [
                'status' => 'Input Gagal',
                'result' => [],
                'message' => $e
            ];
        }
        return response()->json($response,$status); 
    }

    public function cari_detilPP($search)
    {
        $detilPP = DetilPProduk::where('id_penjualan_produk','like','%'.$search.'%')->get();
        if(sizeof($detilPP)==0)
        {
            $status=404;
            $response = [
                'status' => 'Cari Gagal',
                'data' => []
            ];
        }
        else{
            $status=200;
            $response = [
                'status' => 'Cari Berhasil',
                'data' => $detilPP
            ];
        }
        return response()->json($response,$status); 
    }

    public function edit_detilPP(Request $request, $search)
    {
        $detilPP = DetilPProduk::find($search);

        if($detilPP==NULL){
            $status=404;
            $response = [
                'status' => 'Cari Gagal',
                'data' => []
            ];
        }
        else{
            $detilPP->kode_penjualan_produk = $request['kode_penjualan_produk'];
            $detilPP->tgl_penjualan_produk = $request['tgl_penjualan_produk'];
            $detilPP->jml_penjualan_produk = $request['jml_penjualan_produk'];
            $detilPP->subtotal_penjualan_produk = $request['subtotal_penjualan_produk'];
            $detilPP->id_pengadaan_fk = 1;
            $detilPP->id_produk_fk = 1;
            $detilPP->id_transaksi_fk = 1;
            $detilPP->updated_at = Carbon::now();

            try{
                $success = $detilPP->save();
                $status = 200;
                $response = [
                    'status' => 'Edit Berhasil',
                    'data' => $detilPP
                ];  
            }
            catch(\Illuminate\Database\QueryException $e){
                $status = 500;
                $response = [
                    'status' => 'Edit Gagal',
                    'data' => [],
                    'message' => $e
                ];
            }
        }
        return response()->json($response,$status); 
    }

    public function hapus_detilPP($id_penjualan_produk)
    {
        $detilPP = DetilPP::find($id_penjualan_produk);

        if($detilPP==NULL || $detilPP->deleted_at != NULL){
            $status=404;
            $response = [
                'status' => 'Cari Gagal',
                'data' => []
            ];
        }
        else
        {
            $detilPP->created_at = NULL;
            $detilPP->updated_at = NULL;
            $detilPP->deleted_at = Carbon::now();
            $detilPP->save();
            $status=200;
            $response = [
                'status' => 'Hapus Berhasil',
                'data' => $detilPP
            ];   
        }
        return response()->json($response,$status); 
    }
}
