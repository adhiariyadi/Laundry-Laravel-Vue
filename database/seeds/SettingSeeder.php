<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('setting')->insert([
            'id' => 1,
            'name' => 'name',
            'description' => 'Nama Laundry',
            'value' => 'Laundry',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('setting')->insert([
            'id' => 2,
            'name' => 'alamat',
            'description' => 'Alamat Tempat Laundry',
            'value' => 'Jl. Anggur No. 21 A',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('setting')->insert([
            'id' => 3,
            'name' => 'kelurahan',
            'description' => 'Kelurahan',
            'value' => 'Keniten',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('setting')->insert([
            'id' => 4,
            'name' => 'kecamatan',
            'description' => 'Kecamatan',
            'value' => 'Ponorogo',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('setting')->insert([
            'id' => 5,
            'name' => 'kabupaten',
            'description' => 'Kabupaten',
            'value' => 'Ponorogo',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('setting')->insert([
            'id' => 6,
            'name' => 'provinsi',
            'description' => 'Provinsi',
            'value' => 'Jawa Timur',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('setting')->insert([
            'id' => 7,
            'name' => 'kode_pos',
            'description' => 'Kode Pos',
            'value' => '63412',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('setting')->insert([
            'id' => 8,
            'name' => 'saldo',
            'description' => 'Saldo awal laundry',
            'value' => '500000',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
