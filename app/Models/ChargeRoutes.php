<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChargeRoutes extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_charge',
        'id_app_route',
    ];

    public function route()
    {
        return $this->belongsTo(AppRoutes::class, 'id_app_route'); 
    }
}
