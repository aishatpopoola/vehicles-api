<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    
    // these is an array of the data we need the user to fill for inserting and updating vehicle records
    protected $fillable = [
        'maker',
        'model',
        'year',
        'license_plate',
    ];
}
