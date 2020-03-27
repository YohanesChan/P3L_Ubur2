<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UkuranHewan;
use Carbon\Carbon;
class UkuranHwnController extends Controller
{
    public function index()
    {
        $ukuranHwn = UkuranHewan::where('deleted_at',null)->get();
        $response = [
            'status' => 'GET Berhasil',
            'result' => $ukuranHwn,

        ];

        return response()->json($response,200);
    }

    public function tambah_ukuranHwn(Request $request)
    {
        $ukuranHwn = new UkuranHewan();
        $ukuranHwn->nama_ukuran_hewan = $request['nama_ukuran_hewan'];
        $ukuranHwn->id_pegawai_fk = 1;
        $ukuranHwn->created_at = Carbon::now();
        $ukuranHwn->updated_at = Carbon::now();
        try{
            $success = $ukuranHwn->save();
            $status = 200;
            $response = [
                'status' => 'Input Berhasil',
                'result' => $ukuranHwn
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

    public function cari_ukuranHwn($search)
    {
        $ukuranHwn = UkuranHewan::where('nama_ukuran_hewan','like','%'.$search.'%')->get();
        if(sizeof($ukuranHwn)==0)
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
                'data' => $ukuranHwn
            ];
        }
        return response()->json($response,$status); 
    }

    public function edit_ukuranHwn(Request $request, $search)
    {
        $ukuranHwn = UkuranHewan::find($search);

        if($ukuranHwn==NULL){
            $status=404;
            $response = [
                'status' => 'Cari Gagal',
                'data' => []
            ];
        }
        else{
            $ukuranHwn->nama_ukuran_hewan = $request['nama_ukuran_hewan'];
            $ukuranHwn->id_pegawai_fk = 1;
            $ukuranHwn->updated_at = Carbon::now();

            try{
                $success = $ukuranHwn->save();
                $status = 200;
                $response = [
                    'status' => 'Cari Berhasil',
                    'data' => $ukuranHwn
                ];  
            }
            catch(\Illuminate\Database\QueryException $e){
                $status = 500;
                $response = [
                    'status' => 'Cari Gagal',
                    'data' => [],
                    'message' => $e
                ];
            }
        }
        return response()->json($response,$status); 
    }

    public function hapus_ukuranHwn($id_ukuran)
    {
        $ukuranHwn = UkuranHewan::find($id_ukuran);

        if($ukuranHwn==NULL || $ukuranHwn->deleted_at != NULL){
            $status=404;
            $response = [
                'status' => 'Cari Gagal',
                'data' => []
            ];
        }
        else
        {
            $ukuranHwn->created_at = NULL;
            $ukuranHwn->updated_at = NULL;
            $ukuranHwn->deleted_at = Carbon::now();
            $ukuranHwn->save();
            $status=200;
            $response = [
                'status' => 'Hapus Berhasil',
                'data' => $ukuranHwn
            ];   
        }
        return response()->json($response,$status); 
    }
}
