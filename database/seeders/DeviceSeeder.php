<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Device;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Device::create([
            'kipas' => false,
            'ac' => false,
            'air_purifier' => false,
            'led1' => false,
            'led2' => false,
            'led3' => false,
            'kipas_auto' => true,
            'ac_auto' => true,
            'air_purifier_auto' => true,
        ]);
        
    }
}
