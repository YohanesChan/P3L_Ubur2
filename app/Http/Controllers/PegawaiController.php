<?php

namespace App\Http\Controllers;

use App\Pegawai;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pegawai = Pegawai::all('id_pegawai','no_pegawai','nama_pegawai','role_pegawai','alamat_pegawai','birthday_pegawai','username_pegawai','password_pegawai','created_at','updated_at','deleted_at')
        ->where('deleted_at',null);;
        //$pegawai = Pegawai::find('2'); nggo cari berdasar id 2 tanpa ->get()
        //$pegawai = Pegawai::where('nama_pegawai','Wahyu')->get(); nampil semua pegawai bernama wahyu klo pake where harus pake ->get()
        //$pegawai = Pegawai::where('nama_pegawai','Wahyu'); raiso nampil.
        $response = [
            'status' => 'Success',
            'result' => $pegawai, // nggo nampil biasa
            //'result' => $pegawai->getKey(), // nggo nampil pk tok

        ];

        return response()->json($response,200);
    }

    public function tambah_pegawai(Request $request)
    {
        $pegawai = new Pegawai;
        $pegawai->no_pegawai = $request['no_pegawai'];
        $pegawai->nama_pegawai = $request['nama_pegawai'];
        $pegawai->role_pegawai = $request['role_pegawai'];
        $pegawai->alamat_pegawai = $request['alamat_pegawai'];
        $pegawai->birthday_pegawai = $request['birthday_pegawai'];
        $pegawai->telp_pegawai = $request['telp_pegawai'];
        $pegawai->username_pegawai = $request['username_pegawai'];
        $pegawai->password_pegawai = $request['password_pegawai'];
        //'password' => Hash::make($request->newPassword)
        $pegawai->created_at = Carbon::now();
        $pegawai->updated_at = Carbon::now();
        try{
            $success = $pegawai->save();
            $status = 200;
            $response = [
                'status' => 'Success',
                'result' => $pegawai
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

    public function cari_pegawai($search)
    {
        $pegawai = Pegawai::where('nama_pegawai','like','%'.$search.'%')->get();
        if(sizeof($pegawai)==0)
        {
            $status=404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        }
        else{
            $status=200;
            $response = [
                'status' => 'Success',
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
                'status' => 'Data Not Found',
                'data' => []
            ];
        }
        else{
            $pegawai->no_pegawai = $request['no_pegawai'];
            $pegawai->nama_pegawai = $request['nama_pegawai'];
            $pegawai->role_pegawai = $request['role_pegawai'];
            $pegawai->alamat_pegawai = $request['alamat_pegawai'];
            $pegawai->birthday_pegawai = $request['birthday_pegawai'];
            $pegawai->telp_pegawai = $request['telp_pegawai'];
            $pegawai->username_pegawai = $request['username_pegawai'];
            $pegawai->password_pegawai = $request['password_pegawai'];
            $pegawai->updated_at = Carbon::now();

            try{
                $success = $pegawai->save();
                $status = 200;
                $response = [
                    'status' => 'Success',
                    'data' => $pegawai
                ];  
            }
            catch(\Illuminate\Database\QueryException $e){
                $status = 500;
                $response = [
                    'status' => 'Error',
                    'data' => [],
                    'message' => $e
                ];
            }
        }
        return response()->json($response,$status); 
    }

    public function hapus_pegawai($id_pegawai)
    {
        $pegawai = Pegawai::find($id_pegawai);

        if($pegawai==NULL || $pegawai->deleted_at != NULL){
            $status=404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        }
        else
        {
            $pegawai->created_at = NULL;
            $pegawai->updated_at = NULL;
            $pegawai->deleted_at = Carbon::now();
            $pegawai->save();
            $status=200;
            $response = [
                'status' => 'Success',
                'data' => $pegawai
            ];   
        }
        return response()->json($response,$status); 
    }
}
