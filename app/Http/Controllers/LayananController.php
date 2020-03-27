<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Layanan;
use Carbon\Carbon;
class LayananController extends Controller
{
    public function index()
    {
        $layanan = Layanan::where('deleted_at',null)->get();
        $response = [
            'status' => 'GET Berhasil',
            'result' => $layanan,

        ];

        return response()->json($response,200);
    }

    public function tambah_layanan(Request $request)
    {
        $layanan = new Layanan();
        $layanan->nama_layanan = $request['nama_layanan'];
        $layanan->harga_layanan = $request['harga_layanan'];
        $layanan->id_pegawai_fk = 1;
        $layanan->id_ukuran_fk = $request['id_ukuran_fk'];
        $layanan->created_at = Carbon::now();
        $layanan->updated_at = Carbon::now();
        try{
            $success = $layanan->save();
            $status = 200;
            $response = [
                'status' => 'Input Berhasil',
                'result' => $layanan
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

    public function cari_layanan($search)
    {
        $layanan = Layanan::where('nama_layanan','like','%'.$search.'%')->get();
        if(sizeof($layanan)==0)
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
                'data' => $layanan
            ];
        }
        return response()->json($response,$status); 
    }

    public function edit_layanan(Request $request, $search)
    {
        $layanan = Layanan::find($search);

        if($layanan==NULL){
            $status=404;
            $response = [
                'status' => 'Cari Gagal',
                'data' => []
            ];
        }
        else{
            $layanan->harga_layanan = $request['harga_layanan'];
            $layanan->id_pegawai_fk = 1;
            $layanan->id_ukuran_fk = 1;
            $layanan->updated_at = Carbon::now();

            try{
                $success = $layanan->save();
                $status = 200;
                $response = [
                    'status' => 'Update Berhasil',
                    'data' => $layanan
                ];  
            }
            catch(\Illuminate\Database\QueryException $e){
                $status = 500;
                $response = [
                    'status' => 'Update Gagal',
                    'data' => [],
                    'message' => $e
                ];
            }
        }
        return response()->json($response,$status); 
    }

    public function hapus_layanan($id_layanan)
    {
        $layanan = layanan::find($id_layanan);

        if($layanan==NULL || $layanan->deleted_at != NULL){
            $status=404;
            $response = [
                'status' => 'Cari Gagal',
                'data' => []
            ];
        }
        else
        {
            $layanan->created_at = NULL;
            $layanan->updated_at = NULL;
            $layanan->deleted_at = Carbon::now();
            $layanan->save();
            $status=200;
            $response = [
                'status' => 'Delete Berhasil',
                'data' => $layanan
            ];   
        }
        return response()->json($response,$status); 
    }
}
