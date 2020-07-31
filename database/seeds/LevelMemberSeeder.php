<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('level_member')->insert([
            'id' => 1,
            'name' => 'Basic',
            'point' => 5,
            'discount' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('level_member')->insert([
            'id' => 2,
            'name' => 'Gold',
            'point' => 10,
            'discount' => 5,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('level_member')->insert([
            'id' => 3,
            'name' => 'Platinum',
            'point' => 15,
            'discount' => 10,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
