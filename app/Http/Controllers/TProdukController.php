<?php

namespace App\Http\Controllers;

use App\DetilPProduk;
use App\TProduk;
use App\Produk;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tproduk = Tproduk::where('deleted_at',null)->get();
        $response = [
            'status' => 'GET Berhasil',
            'result' => $tproduk,
        ];

        return response()->json($response,200);
    }

    public function tambah_tproduk(Request $request)
    {
        $tproduk = new Tproduk;
        $tproduk->kode_tproduk = $this->generateID();
        $tproduk->status_tproduk = $request['status_tproduk'];
        $tproduk->tgl_tproduk =  Carbon::now()->toDateString();
        $tproduk->total_tproduk = $request['total_tproduk'];
        $tproduk->id_pegawai_fk = $request['id_pegawai_fk'];
        $tproduk->id_customer_fk = $request['id_customer_fk'];
        $tproduk->created_by = $request['created_by'];
        $tproduk->created_at = Carbon::now();
        $tproduk->updated_at = Carbon::now();
        
        try{
            $success = $tproduk->save();
            $status = 200;
            $response = [
                'status' => 'Input Berhasil',
                'result' => $tproduk
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

    public function cari_tproduk($search)
    {
        $tproduk = Tproduk::where('kode_tproduk','like','%'.$search.'%')->get();
        if(sizeof($tproduk)==0)
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
                'data' => $tproduk
            ];
        }
        return response()->json($response,$status); 
    }

    public function edit_tproduk(Request $request, $search)
    {
        $tproduk = Tproduk::find($search);

        if($tproduk==NULL){
            $status=404;
            $response = [
                'status' => 'Cari Gagal',
                'data' => []
            ];
        }
        else{
            $tproduk->status_tproduk = 'selesai';
            $tproduk->created_by = $request['created_by'];
            $tproduk->updated_by = $request['updated_by'];
            $tproduk->updated_at = Carbon::now();

            try{
                $success = $tproduk->save();
                $status = 200;
                $response = [
                    'status' => 'Edit Berhasil',
                    'data' => $tproduk
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

    public function hapus_tproduk($id_tproduk, Request $request)
    {
        $tproduk = Tproduk::find($id_tproduk);

        if($tproduk==NULL || $tproduk->deleted_at != NULL){
            $status=404;
            $response = [
                'status' => 'Cari Gagal',
                'data' => []
            ];
        }
        else
        {
            $tproduk->created_by = $request['created_by'];
            $tproduk->updated_by = $request['updated_by'];
            $tproduk->deleted_by = $request['deleted_by'];
            $tproduk->created_at = NULL;
            $tproduk->updated_at = NULL;
            $tproduk->deleted_at = Carbon::now();
            $tproduk->save();
            $status=200;
            $response = [
                'status' => 'Hapus Berhasil',
                'data' => $tproduk
            ];   
        }
        return response()->json($response,$status); 
    }

    public function generateID()
    {
        $tproduk = tproduk::orderBy('created_at', 'desc')->first();
        $date = Carbon::now()->toDateString();
        if(isset($tproduk))
            {
                $no = substr($tproduk->kode_tproduk,15);

                if($no<9)
                {
                    return 'PR'.'-'.($date).'-'.'00'.($no+1);
                } 
                else if($no<99)
                {
                    return 'PR'.'-'.($date).'-'.'0'.($no+1);
                }
                else
                {
                    return 'PR'.'-'.($date).'-'.($no+1);
                }
            }
            else
            {
                return 'PR'.'-'.($date).'-'.'001';
            }
    }

    public function Totaltproduk($search){
        $detilTp = DetilPProduk::where('deleted_at',null)->where('id_tproduk_fk','=',$search)->sum('harga_produk');
        return $detilTp;
    }

    public function total_tproduk(Request $request, $search)
    {
        $tproduk = Tproduk::find($search);

        if($tproduk==NULL){
            $status=404;
            $response = [
                'status' => 'Cari Gagal',
                'data' => []
            ];
        }
        else{
            $tproduk->total_tproduk = $this->Totaltproduk($search);
            $tproduk->created_by = $request['created_by'];
            $tproduk->updated_by = $request['updated_by'];
            $tproduk->updated_at = Carbon::now();

            try{
                $success = $tproduk->save();
                $status = 200;
                $response = [
                    'status' => 'Edit Berhasil',
                    'data' => $tproduk
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
}
