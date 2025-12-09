<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'kipas',
        'ac',
        'air_purifier',
        'led1',
        'led2',
        'led3',
        'kipas_auto',
        'ac_auto',
        'air_purifier_auto',
    ];
}