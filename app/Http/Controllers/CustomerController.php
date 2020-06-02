<?php

namespace App\Http\Controllers;
use App\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customer = Customer::where('deleted_at',null)->get();
        $response = [
            'status' => 'Success',
            'result' => $customer,

        ];

        return response()->json($response,200);
    }

    public function tambah_customer(Request $request)
    {
        $customer = new customer;
        $customer->nama_customer = $request['nama_customer'];
        $customer->no_customer = $this->generateID();
        $customer->alamat_customer = $request['alamat_customer'];
        $customer->birthday_customer = $request['birthday_customer'];
        $customer->telp_customer = $request['telp_customer'];
        $customer->id_pegawai_fk = $request['id_pegawai_fk'];
        $customer->created_by = $request['created_by'];
        $customer->created_at = Carbon::now();
        $customer->updated_at = Carbon::now();
        try{
            $success = $customer->save();
            $status = 200;
            $response = [
                'status' => 'Success',
                'result' => $customer
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

    public function cari_customer($search)
    {
        $customer = customer::where('nama_customer','like','%'.$search.'%')->get();
        if(sizeof($customer)==0)
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
                'data' => $customer
            ];
        }
        return response()->json($response,$status); 
    }

    public function edit_customer(Request $request, $search)
    {
        $customer = customer::find($search);

        if($customer==NULL){
            $status=404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        }
        else{
            $customer->nama_customer = $request['nama_customer'];
            $customer->alamat_customer = $request['alamat_customer'];
            $customer->telp_customer = $request['telp_customer'];
            $customer->created_by = $request['created_by'];
            $customer->updated_by = $request['updated_by'];
            $customer->updated_at = Carbon::now();

            try{
                $success = $customer->save();
                $status = 200;
                $response = [
                    'status' => 'Success',
                    'data' => $customer
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

    public function hapus_customer($id_customer, Request $request)
    {
        $customer = customer::find($id_customer);

        if($customer==NULL || $customer->deleted_at != NULL){
            $status=404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        }
        else
        {   
            $customer->created_by = $request['created_by'];
            $customer->updated_by = $request['updated_by'];
            $customer->deleted_by = $request['deleted_by'];
            $customer->created_at = NULL;
            $customer->updated_at = NULL;
            $customer->deleted_at = Carbon::now();
            $customer->save();
            $status=200;
            $response = [
                'status' => 'Success',
                'data' => $customer
            ];   
        }
        return response()->json($response,$status); 
    }
    public function generateID()
    {
        $customer = Customer::orderBy('created_at', 'desc')->first();
        
        if(isset($customer))
            {
                $no = substr($customer->no_customer,2);

                if($no<9)
                {
                    return 'CT'.'00'.($no+1);
                } 
                else if($no<99)
                {
                    return 'CT'.'0'.($no+1);
                }
                else
                {
                    return 'CT'.($no+1);
                }
            }
            else
            {
                return 'CT001';
            }
    }
}
