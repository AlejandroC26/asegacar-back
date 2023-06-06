<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'customer',
        'primary_phone',
        'secondary_phone',
        'establishment_name',
        'establishment_address',
    ];
        
}
