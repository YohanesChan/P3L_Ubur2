<?php

namespace App\Http\Controllers;
use App\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::all();
        $response = [
            'status' => 'GET Berhasil',
            'result' => $transaksi,
        ];

        return response()->json($response,200);
    }

    public function tambah_transaksi(Request $request)
    {
        $transaksi = new Transaksi();
        $transaksi->kode_transaksi = $request['kode_transaksi'];
        $transaksi->tgl_transaksi = $request['tgl_transaksi'];
        $transaksi->diskon_transaksi = $request['diskon_transaksi'];
        $transaksi->total_transaksi = $request['total_transaksi'];

        $transaksi->id_pegawai_fk = 1;
        $transaksi->id_customer_fk = 1;
        $transaksi->created_at = Carbon::now();
        $transaksi->updated_at = Carbon::now();
        try{
            $success = $transaksi->save();
            $status = 200;
            $response = [
                'status' => 'Input Berhasil',
                'result' => $transaksi
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

    public function cari_transaksi($search)
    {
        $transaksi = Transaksi::where('id_penjualan_produk','like','%'.$search.'%')->get();
        if(sizeof($transaksi)==0)
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
                'data' => $transaksi
            ];
        }
        return response()->json($response,$status); 
    }

    public function edit_transaksi(Request $request, $search)
    {
        $transaksi = Transaksi::find($search);

        if($transaksi==NULL){
            $status=404;
            $response = [
                'status' => 'Cari Gagal',
                'data' => []
            ];
        }
        else{
            $transaksi->kode_transaksi = $request['kode_transaksi'];
            $transaksi->tgl_transaksi = $request['tgl_transaksi'];
            $transaksi->diskon_transaksi = $request['diskon_transaksi'];
            $transaksi->total_transaksi = $request['total_transaksi'];

            $transaksi->id_pegawai_fk = 1;
            $transaksi->id_customer_fk = 1;
            $transaksi->updated_at = Carbon::now();

            try{
                $success = $transaksi->save();
                $status = 200;
                $response = [
                    'status' => 'Edit Berhasil',
                    'data' => $transaksi
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

    public function hapus_transaksi($id_transaksi)
    {
        $transaksi = transaksi::find($id_transaksi);

        if($transaksi==NULL || $transaksi->deleted_at != NULL){
            $status=404;
            $response = [
                'status' => 'Cari Gagal',
                'data' => []
            ];
        }
        else
        {
            $transaksi->created_at = NULL;
            $transaksi->updated_at = NULL;
            $transaksi->deleted_at = Carbon::now();
            $transaksi->save();
            $status=200;
            $response = [
                'status' => 'Hapus Berhasil',
                'data' => $transaksi
            ];   
        }
        return response()->json($response,$status); 
    }
}
