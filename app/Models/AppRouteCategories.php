<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppRouteCategories extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'icon',
        'label',
        'route',
        'separator'
    ];

    public function routes()
    {
        return $this->hasMany(AppRoutes::class, 'id_app_route_categories');
    }
}
