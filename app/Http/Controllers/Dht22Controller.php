<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use App\Models\Dht22;

class Dht22Controller extends Controller
{
    public function __construct()
    {
        if (Dht22::count() == 0) {
            Dht22::create([
                'temperature' => 0,
                'humidity' => 0,
                'max_temperature' => 0,
                'max_humidity' => 0
            ]);
        }

        $Device = Device::count();
        if ($Device == 0) {
            Device::create([
                'kipas' => false,
                'ac' => false,
                'air_purifier' => false,
                'led1' => false,
                'led2' => false,
                'led3' => false,
                'kipas_auto' => true,
                'ac_auto' => true,
                'air_purifier_auto' => true
            ]);
        }
    }

    public function updateData($tmp, $hmd)
    {
        $dht = Dht22::first();
        $Device = Device::first();

        $dht->temperature = $tmp;
        $dht->humidity = $hmd;
        $dht->save();

        if ($Device->kipas_auto) {
            if ($hmd > $dht->max_temperature) {
                $Device->kipas = true;
            } else {
                $Device->kipas = false;
            }
        } 
        if ($Device->ac_auto) {
            if ($tmp > $dht->max_temperature) {
                $Device->ac = true;
            } else {
                $Device->ac = false;
            }
        }

        if ($Device->air_purifier_auto) {
            if ($hmd > $dht->max_humidity) {
                $Device->air_purifier = true;
            } else {
                $Device->air_purifier = false;
            }
        }

        $Device->save();

        return response()->json([
            'id' => $dht->id,
            'temperature' => $dht->temperature,
            'humidity' => $dht->humidity,
            'max_temperature' => $dht->max_temperature,
            'max_humidity' => $dht->max_humidity,
            'kipas' => (bool)$Device->kipas,
            'ac' => (bool)$Device->ac,
            'air_purifier' => (bool)$Device->air_purifier,
            'led1' => (bool)$Device->led1,
            'led2' => (bool)$Device->led2,
            'led3' => (bool)$Device->led3
        ]);
    }

    public function getData()
    {
        $dht = Dht22::first();
        $Device = Device::first();
        return response()->json([
            'dht' =>  $dht,
            'device' => $Device
            ]);
    }

    public function updateNilaiMaksimal(Request $request)
    {
        $nilai = $request->nilai;
        $jenis_nilai = $request->jenis_nilai;
        $dht = Dht22::first();

        if ($jenis_nilai == 'max_temperature') {
            $dht->max_temperature = $nilai;
            $dht->save();
        } else if ($jenis_nilai == 'max_humidity') {
            $dht->max_humidity = $nilai;
            $dht->save();
        }
        return redirect('/');
    }
}
