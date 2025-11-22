<?php

namespace App\Http\Controllers;

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
    }

    public function updateData($tmp, $hmd)
    {
        $dht = Dht22::first();
        $dht->temperature = $tmp;
        $dht->humidity = $hmd;
        $dht->save();

        return response()->json([$dht]);
    }

    public function getData()
    {
        $dht = Dht22::first();
        return response()->json($dht);
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
