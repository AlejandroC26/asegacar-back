<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChargeCategories extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_charge',
        'id_app_route_categorie',
    ];

    public function appRouteCategory()
    {
        return $this->belongsTo(AppRouteCategories::class, 'id_app_route_categorie');
    }
}
