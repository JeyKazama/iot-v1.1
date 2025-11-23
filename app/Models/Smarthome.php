<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Smarthome extends Model
{
    protected $fillable = [
        'name', 'status'];

    public function hasAttribute($attr)
        {
            return array_key_exists($attr, $this->getAttributes());
        }
        
}
