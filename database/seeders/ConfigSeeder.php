<?php

namespace Database\Seeders;

use App\Models\Config;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'jam_masuk' => [
                'batas_awal' => Carbon::today()->setHour(8)->setMinute(0)->setSecond(0)->format('H:i:s'),
                'batas_akhir' => Carbon::today()->setHour(10)->setMinute(0)->setSecond(0)->format('H:i:s'),
            ],
            'jam_keluar' => [
                'batas_awal' => Carbon::today()->setHour(16)->setMinute(0)->setSecond(0)->format('H:i:s'),
                'batas_akhir' => Carbon::today()->setHour(23)->setMinute(59)->setSecond(0)->format('H:i:s'),
            ]
        ];

        Config::create([
            'nama' => 'absensi',
            'json_data' => json_encode($data)
        ]);
    }
}
