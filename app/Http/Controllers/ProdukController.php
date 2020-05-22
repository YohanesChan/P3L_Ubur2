<?php

namespace App\Http\Controllers;

use App\Produk;
use Illuminate\Http\Request;
use Carbon\Carbon;
class ProdukController extends Controller
{
    public function index()
    {
        $produk= Produk::where('deleted_at',null)->get();
        $response = [
            'status' => 'GET Berhasil',
            'result' => $produk, 
        ];

        return response()->json($response,200);
    }

    public function notifikasi()
    {
        $produk= Produk::where('deleted_at',null)->whereRaw('stok_produk <= stok_minimal')->get();

        if(sizeof($produk)==0)
        {
            return null;
        }
        else{
            $status=200;
            $response = [
                'status' => 'GET Berhasil',
                'result' => $produk, 
            ];
        }

        

        return response()->json($response,200);
    }

    public function tambah_produk(Request $request)
    {
        $produk = new Produk();
        $produk->no_produk = $this->generateID();
        $produk->nama_produk = $request['nama_produk'];
        $produk->harga_produk = $request['harga_produk'];
        $produk->stok_produk = $request['stok_produk'];
        $produk->stok_minimal = $request['stok_minimal'];
        $produk->id_pegawai_fk = $request['id_pegawai_fk'];
        $produk->created_by = $request['created_by'];
        $produk->updated_by = $request['updated_by'];
        $produk->created_at = Carbon::now();
        $produk->updated_at = Carbon::now();

        if($request->hasFile('gambar')){ //gambar_sparepart itu nama variabel dari model
            $dir = 'storage/';
            $extension = strtolower($request->file('gambar')->getClientOriginalExtension());
            $fileName = str_random() . '.' . $extension;
            $request->file('gambar')->move($dir, $fileName);
            $produk->gambar = $fileName;
        }
        try{
            $success = $produk->save();
            $status = 200;
            $response = [
                'status' => 'Success',
                'result' => $produk
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

    public function cari_produk($search)
    {
        $produk = Produk::where('nama_produk','like','%'.$search.'%')->get();
        if(sizeof($produk)==0)
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
                'data' => $produk
            ];
        }
        return response()->json($response,$status); 
    }

    public function edit_produk(Request $request, $search)
    {
        $produk = Produk::find($search);

        if($produk==NULL){
            $status=404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        }
        else{
            $produk->harga_produk = $request['harga_produk'];
            $produk->stok_minimal = $request['stok_minimal'];
            $produk->created_by = $request['created_by'];
            $produk->updated_by = $request['updated_by'];
            $produk->updated_at = Carbon::now();

            try{
                $success = $produk->save();
                $status = 200;
                $response = [
                    'status' => 'Success',
                    'data' => $produk
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

    public function hapus_produk($id_produk, Request $request)
    {
        $produk = Produk::find($id_produk);

        if($produk==NULL || $produk->deleted_at != NULL){
            $status=404;
            $response = [
                'status' => 'Data Not Found',
                'data' => []
            ];
        }
        else
        {
            $produk->created_by = $request['created_by'];
            $produk->updated_by = $request['updated_by'];
            $produk->deleted_by = $request['deleted_by'];
            $produk->created_at = NULL; 
            $produk->updated_at = NULL;
            $produk->deleted_at = Carbon::now();
            $produk->save();
            $status=200;
            $response = [
                'status' => 'Success',
                'data' => $produk
            ];   
        }
        return response()->json($response,$status); 
    }

    public function generateID()
    {
        $produk = Produk::orderBy('created_at', 'desc')->first();
        
        if(isset($produk))
            {
                $no = substr($produk->no_produk,2);

                if($no<9)
                {
                    return 'PD'.'00'.($no+1);
                } 
                else if($no<99)
                {
                    return 'PD'.'0'.($no+1);
                }
                else
                {
                    return 'PD'.($no+1);
                }
            }
            else
            {
                return 'PD001';
            }
    }

    public function sortByPriceAsc()
    {
        $produk= Produk::where('deleted_at',null)->orderBy('harga_produk', 'asc')->get();
        $response = [
            'status' => 'GET Berhasil',
            'result' => $produk, 
        ];
        return response()->json($response,200);
    }

    public function sortByPriceDesc()
    {
        $produk= Produk::where('deleted_at',null)->orderBy('harga_produk', 'desc')->get();
        $response = [
            'status' => 'GET Berhasil',
            'result' => $produk, 
        ];
        return response()->json($response,200);
    }

    public function sortByStockAsc()
    {
        $produk= Produk::where('deleted_at',null)->orderBy('stok_produk', 'asc')->get();
        $response = [
            'status' => 'GET Berhasil',
            'result' => $produk, 
        ];
        return response()->json($response,200);
    }

    public function sortByStockDesc()
    {
        $produk= Produk::where('deleted_at',null)->orderBy('stok_produk', 'desc')->get();
        $response = [
            'status' => 'GET Berhasil',
            'result' => $produk, 
        ];
        return response()->json($response,200);
    }

    // function upload(){
    //     $namaFile = $_FILES['gambar']['name'];
    //     $ukuranFile = $_FILES['gambar']['size'];
    //     $error = $_FILES['gambar']['error'];
    //     $tmpName = $_FILES['gambar']['tmp_name'];

    //      //mengecek file gambar atau bukan
    //     $ekstensiGambarValid = ['jpg','jpeg','png','gif'];
    //     $ekstensiGambar = explode('.',$namaFile);
    //     $ekstensiGambar = strtolower(end($ekstensiGambar));
    //     if(!in_array($ekstensiGambar, $ekstensiGambarValid)){
    //         return 1;
    //     }
        
    //     $gambar=$this->scaleImageFileToBlob($tmpName);
    
    //     return $gambar;
    // }

    // function scaleImageFileToBlob($file) {

    //     $source_pic = $file;
    //     $max_width = 200;
    //     $max_height = 200;
    
    //     list($width, $height, $image_type) = getimagesize($file);
    
    //     switch ($image_type)
    //     {
    //         case 1: $src = imagecreatefromgif($file); break;
    //         case 2: $src = imagecreatefromjpeg($file);  break;
    //         case 3: $src = imagecreatefrompng($file); break;
    //         default: return '';  break;
    //     }
    
    //     $x_ratio = $max_width / $width;
    //     $y_ratio = $max_height / $height;
    
    //     if( ($width <= $max_width) && ($height <= $max_height) ){
    //         $tn_width = $width;
    //         $tn_height = $height;
    //         }elseif (($x_ratio * $height) < $max_height){
    //             $tn_height = ceil($x_ratio * $height);
    //             $tn_width = $max_width;
    //         }else{
    //             $tn_width = ceil($y_ratio * $width);
    //             $tn_height = $max_height;
    //     }
    
    //     $tmp = imagecreatetruecolor($tn_width,$tn_height);
    
    //     /* Check if this image is PNG or GIF, then set if Transparent*/
    //     if(($image_type == 1) OR ($image_type==3))
    //     {
    //         imagealphablending($tmp, false);
    //         imagesavealpha($tmp,true);
    //         $transparent = imagecolorallocatealpha($tmp, 255, 255, 255, 127);
    //         imagefilledrectangle($tmp, 0, 0, $tn_width, $tn_height, $transparent);
    //     }
    //     imagecopyresampled($tmp,$src,0,0,0,0,$tn_width, $tn_height,$width,$height);
    
    //     ob_start();
    
    //     switch ($image_type)
    //     {
    //         case 1: imagegif($tmp); break;
    //         case 2: imagejpeg($tmp, NULL, 100);  break; // best quality
    //         case 3: imagepng($tmp, NULL, 0); break; // no compression
    //         default: echo ''; break;
    //     }
    
    //     $final_image = ob_get_contents();
    
    //     ob_end_clean();
    
    //     return $final_image;
    // }
}
