<?php

namespace App\Http\Controllers;
use App\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $supplier= Supplier::where('deleted_at',null)->get();
        $response = [
            'status' => 'GET Berhasil',
            'result' => $supplier, 
        ];

        return response()->json($response,200);
    }

    public function tambah_supplier(Request $request)
    {
        $supplier = new Supplier;
        $supplier->nama_supplier = $request['nama_supplier'];
        $supplier->alamat_supplier = $request['alamat_supplier'];
        $supplier->telp_supplier = $request['telp_supplier'];
        $supplier->created_at = Carbon::now();
        $supplier->updated_at = Carbon::now();
        try{
            $success = $supplier->save();
            $status = 200;
            $response = [
                'status' => 'Input Berhasil',
                'result' => $supplier
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

    public function cari_supplier($search)
    {
        $supplier = Supplier::where('nama_supplier','like','%'.$search.'%')->get();
        if(sizeof($supplier)==0)
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
                'data' => $supplier
            ];
        }
        return response()->json($response,$status); 
    }

    public function edit_supplier(Request $request, $search)
    {
        $supplier = Supplier::find($search);

        if($supplier==NULL){
            $status=404;
            $response = [
                'status' => 'Cari Gagal',
                'data' => []
            ];
        }
        else{
            $supplier->nama_supplier = $request['nama_supplier'];
            $supplier->alamat_supplier = $request['alamat_supplier'];
            $supplier->telp_supplier = $request['telp_supplier'];
            $supplier->updated_at = Carbon::now();

            try{
                $success = $supplier->save();
                $status = 200;
                $response = [
                    'status' => 'Update Berhasil',
                    'data' => $supplier
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

    public function hapus_supplier($id_supplier)
    {
        $supplier = Supplier::find($id_supplier);

        if($supplier==NULL || $supplier->deleted_at != NULL){
            $status=404;
            $response = [
                'status' => 'Cari Gagal',
                'data' => []
            ];
        }
        else
        {
            $supplier->created_at = NULL;
            $supplier->updated_at = NULL;
            $supplier->deleted_at = Carbon::now();
            $supplier->save();
            $status=200;
            $response = [
                'status' => 'Delete Berhasil',
                'data' => $supplier
            ];   
        }
        return response()->json($response,$status); 
    }
}