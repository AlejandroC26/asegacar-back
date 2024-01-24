<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppRoutes extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'label',
        'route',
        'id_app_route_categories'
    ];

    public function route_categorie()
    {
        return $this->belongsTo(AppRouteCategories::class, 'id_app_route_categories'); 
    }
}
