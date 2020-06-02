<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DetilPLayanan;
use Carbon\Carbon;
class DetilPLController extends Controller
{
    public function index($search)
    {
        $detilPl = DetilPLayanan::where('deleted_at',null)->where('id_tlayanan_fk','=',$search)->get();
        $response = [
            'status' => 'GET Berhasil',
            'result' => $detilPl,
        ];

        return response()->json($response,200);
    }

    public function tambah_detilPl(Request $request)
    {
        $detilPl = new DetilPlayanan();
        $detilPl->nama_layanan = $request['nama_layanan'];
        $detilPl->jml_layanan = $request['jml_layanan'];
        $detilPl->harga_layanan = $request['harga_layanan'];
        $detilPl->id_tlayanan_fk = $request['id_tlayanan_fk'];
        $detilPl->id_layanan_fk = $request['id_layanan_fk'];
        $detilPl->id_hewan_fk = $request['id_hewan_fk'];
        $detilPl->created_by = $request['created_by'];
        $detilPl->created_at = Carbon::now();
        $detilPl->updated_at = Carbon::now();
        try{
            $success = $detilPl->save();
            $status = 200;
            $response = [
                'status' => 'Input Berhasil',
                'result' => $detilPl
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

    public function cari_detilPl($search)
    {
        $detilPl = DetilPlayanan::where('id_playanan','like','%'.$search.'%')->get();
        if(sizeof($detilPl)==0)
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
                'data' => $detilPl
            ];
        }
        return response()->json($response,$status); 
    }

    public function edit_detilPl(Request $request, $search)
    {
        $detilPl = DetilPlayanan::find($search);

        if($detilPl==NULL){
            $status=404;
            $response = [
                'status' => 'Cari Gagal',
                'data' => []
            ];
        }
        else{
            $detilPl->jml_layanan = $request['jml_layanan'];
            $detilPl->harga_layanan = $request['harga_layanan'];
            $detilPl->created_by = $request['created_by'];
            $detilPl->updated_by = $request['updated_by'];
            $detilPl->updated_at = Carbon::now();

            try{
                $success = $detilPl->save();
                $status = 200;
                $response = [
                    'status' => 'Edit Berhasil',
                    'data' => $detilPl
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

    public function hapus_detilPl($id_playanan)
    {
        $detilPl = DetilPlayanan::find($id_playanan);

        if($detilPl==NULL || $detilPl->deleted_at != NULL){
            $status=404;
            $response = [
                'status' => 'Cari Gagal',
                'data' => []
            ];
        }
        else
        {
            $detilPl->delete();
            $status=200;
            $response = [
                'status' => 'Hapus Berhasil',
                'data' => $detilPl
            ];   
        }
        return response()->json($response,$status); 
    }

    public function TotalPengadaan($search){
        $detilPp = DetilPlayanan::where('deleted_at',null)->where('id_tlayanan_fk','=',$search)->sum('harga_layanan');
        return $detilPp;
    }
}
