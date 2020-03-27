<?php

namespace App\Http\Controllers;
use App\Hewan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HewanController extends Controller
{
    public function index()
    {
        $hewan= Hewan::where('deleted_at',null)->get();
        $response = [
            'status' => 'GET Berhasil',
            'result' => $hewan,
        ];

        return response()->json($response,200);
    }

    public function tambah_hewan(Request $request)
    {
        $hewan = new hewan;
        $hewan->nama_hewan = $request['nama_hewan'];
        $hewan->birthday_hewan = $request['birthday_hewan'];
        $hewan->id_pegawai_fk = 1;
        $hewan->id_customer_fk = 1;
        $hewan->id_jenis_fk = 1;
        $hewan->created_at = Carbon::now();
        $hewan->updated_at = Carbon::now();
        try{
            $success = $hewan->save();
            $status = 200;
            $response = [
                'status' => 'Input Berhasil',
                'result' => $hewan
            ];
            
        }catch(\Illuminate\Database\QueryException $e){
            $status = 500;
            $response = [
                'status' => 'Error',
                'result' => [],
                'message' => $e
            ];
        }
        return response()->json($response,$status); 
    }

    public function cari_hewan($search)
    {
        $hewan = Hewan::where('nama_hewan','like','%'.$search.'%')->get();
        if(sizeof($hewan)==0)
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
                'data' => $hewan
            ];
        }
        return response()->json($response,$status); 
    }

    public function edit_hewan(Request $request, $search)
    {
        $hewan = Hewan::find($search);

        if($hewan==NULL){
            $status=404;
            $response = [
                'status' => 'Cari Gagal',
                'data' => []
            ];
        }
        else{
            $hewan->nama_hewan = $request['nama_hewan'];
            $hewan->birthday_hewan = $request['birthday_hewan'];
            $hewan->id_pegawai_fk = 1;///////////////////////////////////////dapetin id fk pie broo
            $hewan->id_customer_fk = 1;///////////////////////////////////////dapetin id fk pie broo
            $hewan->id_jenis_fk = 1;///////////////////////////////////////dapetin id fk pie broo
            $hewan->updated_at = Carbon::now();

            try{
                $success = $hewan->save();
                $status = 200;
                $response = [
                    'status' => 'Update Berhasil',
                    'data' => $hewan
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

    public function hapus_hewan($id_hewan)
    {
        $hewan = hewan::find($id_hewan);

        if($hewan==NULL || $hewan->deleted_at != NULL){
            $status=404;
            $response = [
                'status' => 'Cari Gagal',
                'data' => []
            ];
        }
        else
        {
            $hewan->created_at = NULL;
            $hewan->updated_at = NULL;
            $hewan->deleted_at = Carbon::now();
            $hewan->save();
            $status=200;
            $response = [
                'status' => 'Hapus Berhasil',
                'data' => $hewan
            ];   
        }
        return response()->json($response,$status); 
    }
}
