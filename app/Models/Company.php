<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    public $table = 'company';

    protected $fillable = [
        'name',
        'id_city',
        'adress',
        'phone'
    ];

    public function city() { 
        return $this->belongsTo(City::class, 'id_city'); 
    }
}
