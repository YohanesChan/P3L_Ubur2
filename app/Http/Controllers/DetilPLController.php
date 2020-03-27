<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DetilPLayanan;
use Carbon\Carbon;
class DetilPLController extends Controller
{
    public function index()
    {
        $detilPL = DetilPLayanan::all();
        $response = [
            'status' => 'GET Berhasil',
            'result' => $detilPL,
        ];

        return response()->json($response,200);
    }

    public function tambah_detilPL(Request $request)
    {
        $detilPL = new DetilPL();
        $detilPL->kode_penjualan_layanan = $request['kode_penjualan_layanan'];
        $detilPL->tgl_penjualan_layanan = $request['tgl_penjualan_layanan'];
        $detilPL->jml_penjualan_layanan = $request['jml_penjualan_layanan'];
        $detilPL->subtotal_penjualan_layanan = $request['subtotal_penjualan_layanan'];
        $detilPL->id_pengadaan_fk = 1;
        $detilPL->id_produk_fk = 1;
        $detilPL->id_transaksi_fk = 1;
        $detilPL->id_hewan_fk = 1;
        $detilPL->created_at = Carbon::now();
        $detilPL->updated_at = Carbon::now();
        try{
            $success = $detilPL->save();
            $status = 200;
            $response = [
                'status' => 'Input Berhasil',
                'result' => $detilPL
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

    public function cari_detilPL($search)
    {
        $detilPL = DetilPL::where('id_penjualan_layanan','like','%'.$search.'%')->get();
        if(sizeof($detilPL)==0)
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
                'data' => $detilPL
            ];
        }
        return response()->json($response,$status); 
    }

    public function edit_detilPL(Request $request, $search)
    {
        $detilPL = DetilPL::find($search);

        if($detilPL==NULL){
            $status=404;
            $response = [
                'status' => 'Cari Gagal',
                'data' => []
            ];
        }
        else{
            $detilPL->kode_penjualan_layanan = $request['kode_penjualan_layanan'];
            $detilPL->tgl_penjualan_layanan = $request['tgl_penjualan_layanan'];
            $detilPL->jml_penjualan_layanan = $request['jml_penjualan_layanan'];
            $detilPL->subtotal_penjualan_layanan = $request['subtotal_penjualan_layanan'];
            $detilPL->id_pengadaan_fk = 1;
            $detilPL->id_produk_fk = 1;
            $detilPL->id_transaksi_fk = 1;
            $detilPL->id_hewan_fk = 1;
            $detilPL->updated_at = Carbon::now();

            try{
                $success = $detilPL->save();
                $status = 200;
                $response = [
                    'status' => 'Edit Berhasil',
                    'data' => $detilPL
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

    public function hapus_detilPL($id_penjualan_layanan)
    {
        $detilPL = DetilPL::find($id_penjualan_layanan);

        if($detilPL==NULL || $detilPL->deleted_at != NULL){
            $status=404;
            $response = [
                'status' => 'Cari Gagal',
                'data' => []
            ];
        }
        else
        {
            $detilPL->created_at = NULL;
            $detilPL->updated_at = NULL;
            $detilPL->deleted_at = Carbon::now();
            $detilPL->save();
            $status=200;
            $response = [
                'status' => 'Hapus Berhasil',
                'data' => $detilPL
            ];   
        }
        return response()->json($response,$status); 
    }
}
