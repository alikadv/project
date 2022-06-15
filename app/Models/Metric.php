<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sensor;

class Metric extends Model
{
    // use HasFactory;

    protected $fillable = ['co2', 'time', 'sensor_id'];

    public function sensor()
    {
        return $this->belongsTo(Sensor::class);
    }
}
