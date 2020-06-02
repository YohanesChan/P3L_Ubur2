<?php

namespace App\Http\Controllers;

use App\Pegawai;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pegawai = Pegawai::where('deleted_at', '=', null)->get();
        $response = [
            'status' => 'GET Berhasil',
            'result' => $pegawai,
        ];

        return response()->json($response,200);
    }

    public function tambah_pegawai(Request $request)
    {
        $pegawai = new Pegawai;
        $pegawai->no_pegawai = $this->generateID($request['role_pegawai']);
        $pegawai->nama_pegawai = $request['nama_pegawai'];
        $pegawai->role_pegawai = $request['role_pegawai'];
        $pegawai->alamat_pegawai = $request['alamat_pegawai'];
        $pegawai->birthday_pegawai = $request['birthday_pegawai'];
        $pegawai->telp_pegawai = $request['telp_pegawai'];
        $pegawai->username_pegawai = $request['username_pegawai'];
        $pegawai->password_pegawai = Hash::make($request->password_pegawai);
        $pegawai->created_by = $request['created_by'];
        $pegawai->created_at = Carbon::now();
        $pegawai->updated_at = Carbon::now();
        try{
            $success = $pegawai->save();
            $status = 200;
            $response = [
                'status' => 'Input Berhasil',
                'result' => $pegawai
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

    public function cari_pegawai($search)
    {
        $pegawai = Pegawai::where('nama_pegawai','like','%'.$search.'%')->get();
        if(sizeof($pegawai)==0)
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
                'data' => $pegawai
            ];
        }
        return response()->json($response,$status); 
    }

    public function edit_pegawai(Request $request, $search)
    {
        $pegawai = Pegawai::find($search);

        if($pegawai==NULL){
            $status=404;
            $response = [
                'status' => 'Cari Gagal',
                'data' => []
            ];
        }
        else{
            $pegawai->nama_pegawai = $request['nama_pegawai'];
            $pegawai->alamat_pegawai = $request['alamat_pegawai'];
            $pegawai->birthday_pegawai = $request['birthday_pegawai'];
            $pegawai->telp_pegawai = $request['telp_pegawai'];
            $pegawai->created_by = $request['created_by'];
            $pegawai->updated_by = $request['updated_by'];
            $pegawai->updated_at = Carbon::now();

            try{
                $success = $pegawai->save();
                $status = 200;
                $response = [
                    'status' => 'Edit Berhasil',
                    'data' => $pegawai
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

    public function hapus_pegawai($id_pegawai, Request $request)
    {
        $pegawai = Pegawai::find($id_pegawai);

        if($pegawai==NULL || $pegawai->deleted_at != NULL){
            $status=404;
            $response = [
                'status' => 'Cari Gagal',
                'data' => []
            ];
        }
        else
        {
            $pegawai->created_by = $request['created_by'];
            $pegawai->updated_by = $request['updated_by'];
            $pegawai->deleted_by = $request['deleted_by'];
            $pegawai->created_at = NULL;
            $pegawai->updated_at = NULL;
            $pegawai->deleted_at = Carbon::now();
            $pegawai->save();
            $status=200;
            $response = [
                'status' => 'Hapus Berhasil',
                'data' => $pegawai
            ];   
        }
        return response()->json($response,$status); 
    }

    public function login(Request $request)
    {
        $pegawai = Pegawai::where('username_pegawai', '=', $request->username_pegawai)->first();
        if(is_null($pegawai) || $pegawai->username_pegawai != $request->username_pegawai){
            $status=404;
            $response = [
                'status' => 'Cari Gagal',
                'result' => []
            ];
        }else{
            
            if(Hash::check($request->password_pegawai,$pegawai->password_pegawai)){
                $status=200;
                $response = [
                    'status' => 'GET Berhasil',
                    'result' => $pegawai
                ];
            }else{
                $status=500;
                $response = [
                    'status' => $status,
                    'result' => [],
                    'message'=> 'Login Gagal'
                ];
            }
        }
        return response()->json($response,$status);
    }

    public function generateID($role_pegawai)
    {
        $pegawai = Pegawai::where('role_pegawai',$role_pegawai)
        ->orderBy('created_at', 'desc')->first();
        
        if($role_pegawai=="Owner")
        {
            if(isset($pegawai))
            {
                $no = substr($pegawai->no_pegawai,2);

                if($no<9)
                {
                    return 'OW'.'00'.($no+1);
                } 
                else if($no<99)
                {
                    return 'OW'.'0'.($no+1);
                }
                else
                {
                    return 'OW'.($no+1);
                }
            }
            else
            {
                return 'OW001';
            }
        }else if($role_pegawai=="Customer Service")
        {
            if(isset($pegawai))
            {
                $no = substr($pegawai->no_pegawai,2);

                if($no<9)
                {
                    return 'CS'.'00'.($no+1);
                } 
                else if($no<99)
                {
                    return 'CS'.'0'.($no+1);
                }
                else
                {
                    return 'CS'.($no+1);
                }
            }
            else
            {
                return 'CS001';
            }
        }
        else
        {
            if(isset($pegawai))
            {
                $no = substr($pegawai->no_pegawai,1);

                if($no<9){
                    return 'K'.'00'.($no+1);
                } 
                else if($no<99){
                    return 'K'.'0'.($no+1);
                }
                else
                {
                    return 'K'.($no+1);
                }
            }
            else
            {
                return 'K001';
            }
        }
    }
}
