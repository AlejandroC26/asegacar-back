<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];

    public function dailyRoutes ()
    {
        return $this->hasMany(DailyRoutes::class, 'id_route', 'id');
    }
}
