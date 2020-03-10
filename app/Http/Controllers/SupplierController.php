<?php

namespace App\Http\Controllers;
use App\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $supplier= Supplier::all('id_supplier','nama_supplier','alamat_supplier','telp_supplier','created_at','updated_at','deleted_at')
        ->where('deleted_at',null);;
        //$supplier = supplier::find('2'); nggo cari berdasar id 2 tanpa ->get()
        //$supplier = supplier::where('nama_supplier','Wahyu')->get(); nampil semua supplier bernama wahyu klo pake where harus pake ->get()
        //$supplier = supplier::where('nama_supplier','Wahyu'); raiso nampil.
        $response = [
            'status' => 'Success',
            'result' => $supplier, // nggo nampil biasa
            //'result' => $supplier->getKey(), // nggo nampil pk tok

        ];

        return response()->json($response,200);
    }

    public function tambah_supplier(Request $request)
    {
        $supplier = new Supplier;
        $supplier->nama_supplier = $request['nama_supplier'];
        $supplier->alamat_supplier = $request['alamat_supplier'];
        $supplier->telp_supplier = $request['telp_supplier'];
        //'password' => Hash::make($request->newPassword)
        $supplier->created_at = Carbon::now();
        $supplier->updated_at = Carbon::now();
        try{
            $success = $supplier->save();
            $status = 200;
            $response = [
                'status' => 'Success',
                'result' => $supplier
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

    public function cari_supplier($search)
    {
        $supplier = Supplier::where('nama_supplier','like','%'.$search.'%')->get();
        if(sizeof($supplier)==0)
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
                'status' => 'Data Not Found',
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
                    'status' => 'Success',
                    'data' => $supplier
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

    public function hapus_supplier($id_supplier)
    {
        $supplier = Supplier::find($id_supplier);

        if($supplier==NULL || $supplier->deleted_at != NULL){
            $status=404;
            $response = [
                'status' => 'Data Not Found',
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
                'status' => 'Success',
                'data' => $supplier
            ];   
        }
        return response()->json($response,$status); 
    }
}
