<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drive extends Model
{
    use HasFactory;

     protected $guarded = [];

    // protected $fillable = [
    //     'year'
    // ]

    public function user()
    {
        return $this->belongsTo(User::class);
    }

     public function trips()
    {
        return $this->hasMany(Trip::class);
    }
}
