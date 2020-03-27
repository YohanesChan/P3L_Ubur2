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
        $pegawai = Pegawai::where('deleted_at',null)->get();
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

    public function hapus_pegawai($id_pegawai)
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
                    'status' => 'Login Berhasil',
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
        
        if($role_pegawai==2)
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

    function upload(){
        $namaFile = $_FILES['gambar']['name'];
        $ukuranFile = $_FILES['gambar']['size'];
        $error = $_FILES['gambar']['error'];
        $tmpName = $_FILES['gambar']['tmp_name'];

         //mengecek file gambar atau bukan
        $ekstensiGambarValid = ['jpg','jpeg','png','gif'];
        $ekstensiGambar = explode('.',$namaFile);
        $ekstensiGambar = strtolower(end($ekstensiGambar));
        if(!in_array($ekstensiGambar, $ekstensiGambarValid)){
            return 1;
        }
        
        $gambar=$this->scaleImageFileToBlob($tmpName);
    
        return $gambar;
    }

    function scaleImageFileToBlob($file) {

        $source_pic = $file;
        $max_width = 200;
        $max_height = 200;
    
        list($width, $height, $image_type) = getimagesize($file);
    
        switch ($image_type)
        {
            case 1: $src = imagecreatefromgif($file); break;
            case 2: $src = imagecreatefromjpeg($file);  break;
            case 3: $src = imagecreatefrompng($file); break;
            default: return '';  break;
        }
    
        $x_ratio = $max_width / $width;
        $y_ratio = $max_height / $height;
    
        if( ($width <= $max_width) && ($height <= $max_height) ){
            $tn_width = $width;
            $tn_height = $height;
            }elseif (($x_ratio * $height) < $max_height){
                $tn_height = ceil($x_ratio * $height);
                $tn_width = $max_width;
            }else{
                $tn_width = ceil($y_ratio * $width);
                $tn_height = $max_height;
        }
    
        $tmp = imagecreatetruecolor($tn_width,$tn_height);
    
        /* Check if this image is PNG or GIF, then set if Transparent*/
        if(($image_type == 1) OR ($image_type==3))
        {
            imagealphablending($tmp, false);
            imagesavealpha($tmp,true);
            $transparent = imagecolorallocatealpha($tmp, 255, 255, 255, 127);
            imagefilledrectangle($tmp, 0, 0, $tn_width, $tn_height, $transparent);
        }
        imagecopyresampled($tmp,$src,0,0,0,0,$tn_width, $tn_height,$width,$height);
    
        ob_start();
    
        switch ($image_type)
        {
            case 1: imagegif($tmp); break;
            case 2: imagejpeg($tmp, NULL, 100);  break; // best quality
            case 3: imagepng($tmp, NULL, 0); break; // no compression
            default: echo ''; break;
        }
    
        $final_image = ob_get_contents();
    
        ob_end_clean();
    
        return $final_image;
    }
}
