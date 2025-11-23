<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dht22Controller;
use App\Http\Controllers\SmarthomeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/update-data/{tmp}/{hmd}', [Dht22Controller::class, 'updateData']);
Route::get('/get-data', [Dht22Controller::class, 'getData']);
Route::post('/update-nilai-maksimal', [Dht22Controller::class, 'updateNilaiMaksimal']);
Route::get('/toggle/{device}', [SmarthomeController::class, 'toggle']);
Route::get('/status', [SmarthomeController::class, 'apiStatus']);
