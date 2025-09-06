<?php

namespace Database\Seeders;

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
    $param = [
      'id' => 1,
      'name' => '山田太郎',
      'email' => 'attendance@gmail.com',
      'password' => 'attendance',
    ];
    DB::table('users')->insert($param);
    }
}
