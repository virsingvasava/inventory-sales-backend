<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutletLocation extends Model
{
    use HasFactory;
    
    protected $table = 'outlet_location';

    protected $fillable = [
        'name',
        'status',
    ];
}
