<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    public $table = 'persons';
    protected $fillable = [
        'fullname',
        'document',
        'expedition_city',
        'adress',
        'phone',
    ];
}
