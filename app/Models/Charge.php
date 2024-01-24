<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function routes()
    {
        return $this->hasMany(ChargeRoutes::class, 'id_charge');
    }

    public function chargeCategories()
    {
        return $this->hasMany(ChargeCategories::class, 'id_charge');
    }

    public function appRoutes()
    {
        return $this->hasManyThrough(
            AppRoutes::class,
            ChargeRoutes::class,
            'id_charge',
            'id',
            'id',
            'id_app_route'
        );
    }

    public function appRouteCategories()
    {
        return $this->hasManyThrough(
            AppRouteCategories::class,
            ChargeCategories::class,
            'id_charge',
            'id',
            'id',
            'id_app_route_categorie'
        );
    }
}
