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
        $supplier->no_supplier = $this->generateID();
        $supplier->nama_supplier = $request['nama_supplier'];
        $supplier->alamat_supplier = $request['alamat_supplier'];
        $supplier->id_pegawai_fk = $request['id_pegawai_fk'];
        $supplier->telp_supplier = $request['telp_supplier'];
        $supplier->created_by = $request['created_by'];

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
            $supplier->created_by = $request['created_by'];
            $supplier->updated_by = $request['updated_by'];
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

    public function hapus_supplier($id_supplier, Request $request)
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
            $supplier->created_by = $request['created_by'];
            $supplier->updated_by = $request['updated_by'];
            $supplier->deleted_by = $request['deleted_by'];
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

    public function generateID()
    {
        $supplier = Supplier::orderBy('created_at', 'desc')->first();
        
        if(isset($supplier))
            {
                $no = substr($supplier->no_supplier,2);

                if($no<9)
                {
                    return 'SP'.'00'.($no+1);
                } 
                else if($no<99)
                {
                    return 'SP'.'0'.($no+1);
                }
                else
                {
                    return 'SP'.($no+1);
                }
            }
            else
            {
                return 'SP001';
            }
    }
}
