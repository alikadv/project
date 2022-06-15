<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Metric;

class Sensor extends Model
{
    use HasFactory;
    protected $fillable = ['uuid', 'status'];
    public function mertics()
    {

        return $this->hasMany(Metric::class);
    }
}
