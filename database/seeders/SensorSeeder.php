<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class SensorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sensors')->insert([
            'uuid' =>"b8054a4b-d434-4e07-891d-8273327631a4",
            'status' => "OK",
        ]);
    }
}
