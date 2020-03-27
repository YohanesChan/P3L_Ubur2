<?php

namespace App\Http\Controllers;
use App\Pengadaan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PengadaanController extends Controller
{
    public function index()
    {
        $pengadaan = Pengadaan::where('deleted_at',null)->get();
        $response = [
            'status' => 'GET Berhasil',
            'result' => $pengadaan,
        ];

        return response()->json($response,200);
    }

    public function tambah_pengadaan(Request $request)
    {
        $pengadaan = new pengadaan;
        $pengadaan->kode_pengadaan = $request['kode_pengadaan'];
        $pengadaan->Status_PO = $request['status_PO'];
        $pengadaan->tgl_pengadaan = $request['tgl_pengadaan'];
        $pengadaan->total_pengadaan = $request['total_pengadaan'];
        $pengadaan->id_pegawai_fk = 1;
        $pengadaan->id_supplier_fk = 1;
        $pengadaan->created_at = Carbon::now();
        $pengadaan->updated_at = Carbon::now();
        try{
            $success = $pengadaan->save();
            $status = 200;
            $response = [
                'status' => 'Input Berhasil',
                'result' => $pengadaan
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

    public function cari_pengadaan($search)
    {
        $pengadaan = pengadaan::where('kode_pengadaan','like','%'.$search.'%')->get();
        if(sizeof($pengadaan)==0)
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
                'data' => $pengadaan
            ];
        }
        return response()->json($response,$status); 
    }

    public function edit_pengadaan(Request $request, $search)
    {
        $pengadaan = pengadaan::find($search);

        if($pengadaan==NULL){
            $status=404;
            $response = [
                'status' => 'Cari Gagal',
                'data' => []
            ];
        }
        else{
            $pengadaan->kode_pengadaan = $request['kode_pengadaan'];
            $pengadaan->Status_PO = $request['status_PO'];
            $pengadaan->tgl_pengadaan = $request['tgl_pengadaan'];
            $pengadaan->total_pengadaan = $request['total_pengadaan'];
            $pengadaan->id_pegawai_fk = 1;
            $pengadaan->id_supplier_fk = 1;
            $pengadaan->updated_at = Carbon::now();

            try{
                $success = $pengadaan->save();
                $status = 200;
                $response = [
                    'status' => 'Edit Berhasil',
                    'data' => $pengadaan
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

    public function hapus_pengadaan($id_pengadaan)
    {
        $pengadaan = pengadaan::find($id_pengadaan);

        if($pengadaan==NULL || $pengadaan->deleted_at != NULL){
            $status=404;
            $response = [
                'status' => 'Cari Gagal',
                'data' => []
            ];
        }
        else
        {
            $pengadaan->created_at = NULL;
            $pengadaan->updated_at = NULL;
            $pengadaan->deleted_at = Carbon::now();
            $pengadaan->save();
            $status=200;
            $response = [
                'status' => 'Hapus Berhasil',
                'data' => $pengadaan
            ];   
        }
        return response()->json($response,$status); 
    }
}
