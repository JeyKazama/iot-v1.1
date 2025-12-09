<?php

use App\Http\Controllers\DeviceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dht22Controller;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/update-data/{tmp}/{hmd}', [Dht22Controller::class, 'updateData']);
Route::get('/get-data', [Dht22Controller::class, 'getData']);
Route::post('/update-nilai-maksimal', [Dht22Controller::class, 'updateNilaiMaksimal']);
Route::get('/toggle/{device}', [DeviceController::class, 'toggle']);
Route::get('/status', [DeviceController::class, 'apiStatus']);
// Device Controller Routes
Route::get('/get-device-status', [DeviceController::class, 'getDeviceStatus']);
Route::post('/update-device', [DeviceController::class, 'updateDevice']);
Route::post('/update-device-mode', [DeviceController::class, 'updateDeviceMode']);
