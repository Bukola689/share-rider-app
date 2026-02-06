<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

     protected $guarded = [];

     protected $table = 'trips';

     protected $fillable = [
        'origin',
        'destination',
        'destination_name',
        'user_id',
        'driver_id',
        'driver_location',
        'is_started',
        'is_complete'
     ];

     protected $casts = [
        'origin' => 'array',
        'destination' => 'array',
        'driver_location' => 'array',
        'is_started' => 'boolean',
        'is_complete' => 'boolean'
     ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
