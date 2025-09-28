<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttendanceTableSeeder extends Seeder
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
        'user_id' => 1,
        'punch_in' => '2025-08-07 10:00:00',
        'punch_out' => '2025-08-07 18:00:00',
        'created_at'=> now(),
        'updated_at'=> now(),
    ];
    DB::table('works')->insert($param);

    $param = [
        'id' => 1,
        'work_id' => 1,
        'rest_in' => '2025-08-07 12:00:00',
        'rest_out' => '2025-08-07 13:00:00',
        'created_at'=> now(),
        'updated_at'=> now(),
    ];
    DB::table('rests')->insert($param);
    }
}
