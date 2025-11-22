<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dht22 extends Model
{
    protected $fillable = [
        'temperature','humidity',
        'max_temperature','max_humidity',
        'device_tv','device_ac','device_lamp',
        'device_fridge','device_wifi','device_computer'
    ];
}
