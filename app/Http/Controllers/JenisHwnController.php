<?php

namespace App\Http\Controllers;
use App\JenisHewan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class JenisHwnController extends Controller
{
    public function index()
    {
        $jenisHwn = JenisHewan::where('deleted_at',null)->get();
        $response = [
            'status' => 'GET Berhasil',
            'result' => $jenisHwn,
        ];

        return response()->json($response,200);
    }

    public function tambah_jenisHwn(Request $request)
    {
        $jenisHwn = new JenisHewan();
        $jenisHwn->nama_jenis_hewan = $request['nama_jenis_hewan'];
        $jenisHwn->id_pegawai_fk = $request['id_pegawai_fk'];
        $jenisHwn->created_by = $request['created_by'];
        $jenisHwn->updated_by = $request['updated_by'];
        $jenisHwn->created_at = Carbon::now();
        $jenisHwn->updated_at = Carbon::now();
        try{
            $success = $jenisHwn->save();
            $status = 200;
            $response = [
                'status' => 'Input Berhasil',
                'result' => $jenisHwn
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

    public function cari_jenisHwn($search)
    {
        $jenisHwn = JenisHewan::where('nama_jenis_hewan','like','%'.$search.'%')->get();
        if(sizeof($jenisHwn)==0)
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
                'data' => $jenisHwn
            ];
        }
        return response()->json($response,$status); 
    }

    public function edit_jenisHwn(Request $request, $search)
    {
        $jenisHwn = JenisHewan::find($search);

        if($jenisHwn==NULL){
            $status=404;
            $response = [
                'status' => 'Cari Gagal',
                'data' => []
            ];
        }
        else{
            $jenisHwn->nama_jenis_hewan = $request['nama_jenis_hewan'];
            $jenisHwn->created_by = $request['created_by'];
            $jenisHwn->updated_by = $request['updated_by'];
            $jenisHwn->updated_at = Carbon::now();

            try{
                $success = $jenisHwn->save();
                $status = 200;
                $response = [
                    'status' => 'Update Berhasil',
                    'data' => $jenisHwn
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

    public function hapus_jenisHwn($id_jenis, Request $request)
    {
        $jenisHwn = JenisHewan::find($id_jenis);

        if($jenisHwn==NULL || $jenisHwn->deleted_at != NULL){
            $status=404;
            $response = [
                'status' => 'Cari Gagal',
                'data' => []
            ];
        }
        else
        {
            $jenisHwn->created_by = $request['created_by'];
            $jenisHwn->updated_by = $request['updated_by'];
            $jenisHwn->deleted_by = $request['deleted_by'];
            $jenisHwn->created_at = NULL;
            $jenisHwn->updated_at = NULL;
            $jenisHwn->deleted_at = Carbon::now();
            $jenisHwn->save();
            $status=200;
            $response = [
                'status' => 'Delete Berhasil',
                'data' => $jenisHwn
            ];   
        }
        return response()->json($response,$status); 
    }
}
