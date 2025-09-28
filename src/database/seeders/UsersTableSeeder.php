<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
      'email' => 'attendance@coachtech.com',
      'password' => Hash::make('attendance1234'),
      'role' => 'user',
    ];
    DB::table('users')->insert($param);

    $param = [
      'id' => 2,
      'name' => '山田加奈子',
      'email' => 'admin_attendance@coachtech.com',
      'password' => Hash::make('admin1234'),
      'role' => 'admin',
    ];
    DB::table('users')->insert($param);
    }
}
