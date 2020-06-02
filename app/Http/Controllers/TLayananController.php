<?php

namespace App\Http\Controllers;

use App\DetilPLayanan;
use App\TLayanan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Notifications\Channels\NexmoSmsChannel;
use Illuminate\Notifications\Messages\NexmoMessage;
use Nexmo\Client\Fascade\Nexmo;

class TLayananController extends Controller
{
    public function index()
    {
        $tlayanan = TLayanan::where('deleted_at',null)->get();
        $response = [
            'status' => 'GET Berhasil',
            'result' => $tlayanan,
        ];

        return response()->json($response,200);
    }

    public function index_onproccess()
    {
        $tlayanan = TLayanan::where('deleted_at',null)->where('status_tlayanan','proses')->get();
        $response = [
            'status' => 'GET Berhasil',
            'result' => $tlayanan,
        ];

        return response()->json($response,200);
    }

    public function index_onfinish()
    {
        $tlayanan = TLayanan::where('deleted_at',null)->where('status_tlayanan','selesai')->get();
        $response = [
            'status' => 'GET Berhasil',
            'result' => $tlayanan,
        ];

        return response()->json($response,200);
    }

    public function tambah_tlayanan(Request $request)
    {
        $tlayanan = new Tlayanan;
        $tlayanan->kode_tlayanan = $this->generateID();
        $tlayanan->status_tlayanan = $request['status_tlayanan'];
        $tlayanan->tgl_tlayanan =  Carbon::now()->toDateString();
        $tlayanan->total_tlayanan = $request['total_tlayanan'];
        $tlayanan->id_pegawai_fk = $request['id_pegawai_fk'];
        $tlayanan->id_customer_fk = $request['id_customer_fk'];
        $tlayanan->created_by = $request['created_by'];
        $tlayanan->created_at = Carbon::now();
        $tlayanan->updated_at = Carbon::now();
        
        try{
            $success = $tlayanan->save();
            $status = 200;
            $response = [
                'status' => 'Input Berhasil',
                'result' => $tlayanan
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

    public function cari_tlayanan($search)
    {
        $tlayanan = Tlayanan::where('kode_tlayanan','like','%'.$search.'%')->get();
        if(sizeof($tlayanan)==0)
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
                'data' => $tlayanan
            ];
        }
        return response()->json($response,$status); 
    }

    public function edit_tlayanan(Request $request, $search)
    {
        $tlayanan = Tlayanan::find($search);

        if($tlayanan==NULL){
            $status=404;
            $response = [
                'status' => 'Cari Gagal',
                'data' => []
            ];
        }
        else{
            $tlayanan->status_tlayanan = 'selesai';
            $tlayanan->created_by = $request['created_by'];
            $tlayanan->updated_by = $request['updated_by'];
            $tlayanan->updated_at = Carbon::now();
            $this->sms();

            try{
                $success = $tlayanan->save();
                $status = 200;
                $response = [
                    'status' => 'Edit Berhasil',
                    'data' => $tlayanan
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

    public function hapus_tlayanan($id_tlayanan, Request $request)
    {
        $tlayanan = Tlayanan::find($id_tlayanan);

        if($tlayanan==NULL || $tlayanan->deleted_at != NULL){
            $status=404;
            $response = [
                'status' => 'Cari Gagal',
                'data' => []
            ];
        }
        else
        {
            $tlayanan->created_by = $request['created_by'];
            $tlayanan->updated_by = $request['updated_by'];
            $tlayanan->deleted_by = $request['deleted_by'];
            $tlayanan->created_at = NULL;
            $tlayanan->updated_at = NULL;
            $tlayanan->deleted_at = Carbon::now();
            $tlayanan->save();
            $status=200;
            $response = [
                'status' => 'Hapus Berhasil',
                'data' => $tlayanan
            ];   
        }
        return response()->json($response,$status); 
    }

    public function generateID()
    {
        $tlayanan = tlayanan::orderBy('created_at', 'desc')->first();
        
        if(isset($tlayanan))
            {
                $no = substr($tlayanan->kode_tlayanan,15);
                $date = Carbon::now()->toDateString();

                if($no<9)
                {
                    return 'LY'.'-'.($date).'-'.'00'.($no+1);
                } 
                else if($no<99)
                {
                    return 'LY'.'-'.($date).'-'.'0'.($no+1);
                }
                else
                {
                    return 'LY'.'-'.($date).'-'.($no+1);
                }
            }
            else
            {
                return 'LY'.'-'.($date).'-'.'001';
            }
    }

    public function Totaltlayanan($search){
        $detilTp = DetilPLayanan::where('deleted_at',null)->where('id_tlayanan_fk','=',$search)->sum('harga_layanan');
        return $detilTp;
    }

    public function total_tlayanan(Request $request, $search)
    {
        $tlayanan = Tlayanan::find($search);

        if($tlayanan==NULL){
            $status=404;
            $response = [
                'status' => 'Cari Gagal',
                'data' => []
            ];
        }
        else{
            $tlayanan->total_tlayanan = $this->Totaltlayanan($search);
            $tlayanan->created_by = $request['created_by'];
            $tlayanan->updated_by = $request['updated_by'];
            $tlayanan->updated_at = Carbon::now();

            try{
                $success = $tlayanan->save();
                $status = 200;
                $response = [
                    'status' => 'Edit Berhasil',
                    'data' => $tlayanan
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

    public function sms(){
        $basic  = new \Nexmo\Client\Credentials\Basic('198caecb', 'gR3JQ1VvppAzhYty');
        $client = new \Nexmo\Client($basic);

        $message = $client->message()->send([
            'to' => '6288225441886',
            'from' => 'KouveePet',
            'text' => 'Layanan Anda telah selesai'
        ]);
    }
}
