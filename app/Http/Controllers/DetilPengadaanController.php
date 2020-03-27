<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DetilPengadaan;
use Carbon\Carbon;
class DetilPengadaanController extends Controller
{
    public function index()
    {
        $detilP = DetilPengadaan::all();
        $response = [
            'status' => 'GET Berhasil',
            'result' => $detilP,
        ];

        return response()->json($response,200);
    }

    public function tambah_detilP(Request $request)
    {
        $detilP = new DetilPengadaan();
        $detilP->nama_produk = $request['nama_produk'];
        $detilP->jml_produk = $request['jml_produk'];
        $detilP->harga_produk = $request['harga_produk'];
        $detilP->id_pengadaan_fk = 1;
        $detilP->id_produk_fk = 1;
        $detilP->created_at = Carbon::now();
        $detilP->updated_at = Carbon::now();
        try{
            $success = $detilP->save();
            $status = 200;
            $response = [
                'status' => 'Input Berhasil',
                'result' => $detilP
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

    public function cari_detilP($search)
    {
        $detilP = DetilPengadaan::where('id_detil_pengadaan','like','%'.$search.'%')->get();
        if(sizeof($detilP)==0)
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
                'data' => $detilP
            ];
        }
        return response()->json($response,$status); 
    }

    public function edit_detilP(Request $request, $search)
    {
        $detilP = DetilPengadaan::find($search);

        if($detilP==NULL){
            $status=404;
            $response = [
                'status' => 'Cari Gagal',
                'data' => []
            ];
        }
        else{
            $detilP->nama_produk = $request['nama_produk'];
            $detilP->jml_produk = $request['jml_produk'];
            $detilP->harga_produk = $request['harga_produk'];
            $detilP->id_pengadaan_fk = 1;
            $detilP->id_produk_fk = 1;
            $detilP->updated_at = Carbon::now();

            try{
                $success = $detilP->save();
                $status = 200;
                $response = [
                    'status' => 'Edit Berhasil',
                    'data' => $detilP
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

    public function hapus_detilP($id_detilP)
    {
        $detilP = DetilPengadaan::find($id_detilP);

        if($detilP==NULL || $detilP->deleted_at != NULL){
            $status=404;
            $response = [
                'status' => 'Cari Gagal',
                'data' => []
            ];
        }
        else
        {
            $detilP->created_at = NULL;
            $detilP->updated_at = NULL;
            $detilP->deleted_at = Carbon::now();
            $detilP->save();
            $status=200;
            $response = [
                'status' => 'Hapus Berhasil',
                'data' => $detilP
            ];   
        }
        return response()->json($response,$status); 
    }
}
