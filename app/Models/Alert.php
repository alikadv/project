<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    use HasFactory;

    protected $fillable = ['startTime', 'endTime', 'mesurement1','mesurement2','mesurement3','sensor_id'];

    public function sensor()
    {
        return $this->belongsTo(Sensor::class);
    }
}
