<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pegawais')->insert([
            'id_pegawai' => '1',
        	'no_pegawai' => 'ABC',
        	'nama_pegawai' => 'ABC',
        	'role_pegawai' => 'Owner',
            'alamat_pegawai' => 'ABC',
            'birthday_pegawai' => '1910/10/10',
            'telp_pegawai' => '123',
            'username_pegawai' => 'ABC',
            'password_pegawai' => 'ABC'
        ]);
        DB::table('customers')->insert([    
            'id_customer' => '1',
        	'nama_customer' => 'ABC',
            'alamat_customer' => 'ABC',
            'birthday_customer' => '1910/10/10',
            'telp_customer' => '123',
            'id_pegawai_fk' => '1'
        ]);
        DB::table('produks')->insert([
            'id_produk' => '1',
        	'no_produk' => 'ABC',
        	'nama_produk' => 'ABC',
            'harga_produk' => '123',
            'stok_produk' => '123',
            'stok_minimal' => '123',
            'id_pegawai_fk' => '1'
        ]);
        DB::table('ukuran_hewans')->insert([
        	'id_ukuran' => '1',
            'id_pegawai_fk' => '1'
        ]);
        DB::table('jenis_hewans')->insert([
        	'id_jenis' => '1',
            'id_pegawai_fk' => '1'
        ]);
        DB::table('hewans')->insert([    
        	'nama_hewan' => 'ABC',
            'no_hewan' => 'ABC',
            'birthday_hewan' => '1910/10/10',
            'id_customer_fk' => '1',
            'id_pegawai_fk' => '1',
            'id_jenis_fk' => '1'
        ]);
        DB::table('layanans')->insert([
            'id_layanan' => '1',
        	'no_layanan' => 'ABC',
        	'nama_layanan' => 'ABC',
            'harga_layanan' => '123',
            'id_pegawai_fk' => '1',
            'id_ukuran_fk' => '1'
        ]);
    }
}
