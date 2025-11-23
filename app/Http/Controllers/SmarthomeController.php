<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Smarthome;

class SmarthomeController extends Controller
{
    public function index()
    {
        $data = Smarthome::first();
        return response()->json($data);
    }

    public function toggle($device)
{
    // Ambil record pertama
    $data = Smarthome::first();

    // Cek apakah kolom device ada
    if (!isset($data->$device)) {
        return back()->with('error', 'Device tidak ditemukan');
    }

    // Lakukan toggle (negasi)
    $data->$device = !$data->$device;
    $data->save();

    return back()->with('success', ucfirst($device).' berhasil diubah');
}


    public function apiStatus()
    {
        return response()->json([          
            'lampu_tidur' => (bool)$data->lampu_tidur,            
            'ac' => (bool)$data->ac,            
            'wifi' => (bool)$data->wifi,            
            'smart_plug' => (bool)$data->smart_plug,            
            'smart_lock' => (bool)$data->smart_lock,            
        ]);
    }
}
