<?php

namespace App\Http\Controllers;
use App\Pengadaan;
use App\Produk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\DetilPengadaan;

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
        $pengadaan->kode_pengadaan = $this->generateID();
        $pengadaan->Status_PO = $request['status_PO'];
        $pengadaan->tgl_pengadaan =  Carbon::now()->toDateString();
        $pengadaan->total_pengadaan = $request['total_pengadaan'];
        $pengadaan->id_pegawai_fk = $request['id_pegawai_fk'];
        $pengadaan->id_supplier_fk = $request['id_supplier_fk'];
        $pengadaan->created_by = $request['created_by'];
        $pengadaan->updated_by = $request['updated_by'];
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
            $pengadaan->status_PO = $request['status_PO'];
            $pengadaan->created_by = $request['created_by'];
            $pengadaan->updated_by = $request['updated_by'];
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

    public function hapus_pengadaan($id_pengadaan, Request $request)
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
            $pengadaan->created_by = $request['created_by'];
            $pengadaan->updated_by = $request['updated_by'];
            $pengadaan->deleted_by = $request['deleted_by'];
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

    public function generateID()
    {
        $pengadaan = Pengadaan::orderBy('created_at', 'desc')->first();
        
        if(isset($pengadaan))
            {
                $no = substr($pengadaan->kode_pengadaan,15);
                $date = Carbon::now()->toDateString();

                if($no<9)
                {
                    return 'PO'.'-'.($date).'-'.'00'.($no+1);
                } 
                else if($no<99)
                {
                    return 'PO'.'-'.($date).'-'.'0'.($no+1);
                }
                else
                {
                    return 'PO'.'-'.($date).'-'.($no+1);
                }
            }
            else
            {
                return 'PO'.'-'.($date).'-'.'001';
            }
    }

    public function TotalPengadaan($search){
        $detilP = DetilPengadaan::where('deleted_at',null)->where('id_pengadaan_fk','=',$search)->sum('harga_produk');
        return $detilP;
    }

    public function total_pengadaan(Request $request, $search)
    {
        $pengadaan = Pengadaan::find($search);

        if($pengadaan==NULL){
            $status=404;
            $response = [
                'status' => 'Cari Gagal',
                'data' => []
            ];
        }
        else{
            $pengadaan->total_pengadaan = $this->TotalPengadaan($search);
            $pengadaan->created_by = $request['created_by'];
            $pengadaan->updated_by = $request['updated_by'];
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

    public function UpdateJmlProduk($search){
        $pengadaan = Pengadaan::where('deleted_at',null)->where('id_pengadaan','=',$search)->first();
        //cek ststus
        if($pengadaan->status_PO == 'proses'){
        $detilP = DetilPengadaan::where('id_pengadaan_fk','=',$search)->get();
        
            foreach ($detilP as $row){
                // $detail_p = $row->id_produk_fk;
                
                $produk = Produk::where('deleted_at',null)->where('id_produk','=',$row->id_produk_fk)->first();
                // return response()->json($produk);
                $produk->stok_produk = $produk->stok_produk + $row->jml_produk;
                $produk->save();
            }
            $pengadaan->status_PO ='selesai';  
            try{
                $success = $pengadaan->save();
                $status = 200;
                $response = [
                    'status' => 'Konfirmasi Berhasil',
                    'data' => $pengadaan
                ];  
            }
            catch(\Illuminate\Database\QueryException $e){
                $status = 500;
                $response = [
                    'status' => 'Konfirmasi Gagal',
                    'data' => [],
                    'message' => $e
                ];
            }
        }
        return response()->json($response,$status); 
    }

}
