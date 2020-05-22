<?php

namespace App\Http\Controllers;
use App\DetilPProduk;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DetilPPController extends Controller
{
    public function index($search)
    {
        $detilPp = DetilPProduk::where('deleted_at',null)->where('id_tproduk_fk','=',$search)->get();
        $response = [
            'status' => 'GET Berhasil',
            'result' => $detilPp,
        ];

        return response()->json($response,200);
    }

    public function tambah_detilPp(Request $request)
    {
        $detilPp = new DetilPProduk();
        $detilPp->nama_produk = $request['nama_produk'];
        $detilPp->jml_produk = $request['jml_produk'];
        $detilPp->harga_produk = $request['harga_produk'];
        $detilPp->id_tproduk_fk = $request['id_tproduk_fk'];
        $detilPp->id_produk_fk = $request['id_produk_fk'];
        $detilPp->created_by = $request['created_by'];
        $detilPp->updated_by = $request['updated_by'];
        $detilPp->created_at = Carbon::now();
        $detilPp->updated_at = Carbon::now();
        try{
            $success = $detilPp->save();
            $status = 200;
            $response = [
                'status' => 'Input Berhasil',
                'result' => $detilPp
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

    public function cari_detilPp($search)
    {
        $detilPp = DetilPProduk::where('id_pproduk','like','%'.$search.'%')->get();
        if(sizeof($detilPp)==0)
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
                'data' => $detilPp
            ];
        }
        return response()->json($response,$status); 
    }

    public function edit_detilPp(Request $request, $search)
    {
        $detilPp = DetilPProduk::find($search);

        if($detilPp==NULL){
            $status=404;
            $response = [
                'status' => 'Cari Gagal',
                'data' => []
            ];
        }
        else{
            $detilPp->jml_produk = $request['jml_produk'];
            $detilPp->harga_produk = $request['harga_produk'];
            $detilPp->created_by = $request['created_by'];
            $detilPp->updated_by = $request['updated_by'];
            $detilPp->updated_at = Carbon::now();

            try{
                $success = $detilPp->save();
                $status = 200;
                $response = [
                    'status' => 'Edit Berhasil',
                    'data' => $detilPp
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

    public function hapus_detilPp($id_pproduk)
    {
        $detilPp = DetilPProduk::find($id_pproduk);

        if($detilPp==NULL || $detilPp->deleted_at != NULL){
            $status=404;
            $response = [
                'status' => 'Cari Gagal',
                'data' => []
            ];
        }
        else
        {
            $detilPp->delete();
            $status=200;
            $response = [
                'status' => 'Hapus Berhasil',
                'data' => $detilPp
            ];   
        }
        return response()->json($response,$status); 
    }

    public function TotalPengadaan($search){
        $detilPp = DetilPProduk::where('deleted_at',null)->where('id_tproduk_fk','=',$search)->sum('harga_produk');
        return $detilPp;
    }
}
