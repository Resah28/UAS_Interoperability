<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Train extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'station_id', 'slug', 'kelas'];

    public function station()
    {
        return $this->belongsTo(Station::class);
    }
}
