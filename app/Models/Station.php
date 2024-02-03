<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    // use HasFactory;

    // Station -> table_name = stations
    // custome table name :
    // protected $table = 'table_name'

    // define column name
    protected $fillable = ['nama', 'slug', 'kota'];

    // untuk melakukan update field create_at dan updated_at secara otomatis
    public $timestamp = true;

    public function trains()
    {
        return $this->hasMany(Train::class);
    }
    
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
