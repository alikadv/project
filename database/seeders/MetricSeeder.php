<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MetricSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $current = Carbon::now();
        $time=$current->subDays(3);

        for($i = 0; $i <= 4320; $i++) {
            $time=$time->addMinute();
            $CO2=rand(1000,7000);
            DB::table('metrics')->insert([
                'co2' =>$CO2,
                'time' => $time,
                'sensor_id' => 1,
            ]);
        }
    }
}
