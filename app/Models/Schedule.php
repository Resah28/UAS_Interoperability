<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = ['waktu_berangkat', 'waktu_tiba'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
