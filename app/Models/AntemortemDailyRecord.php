<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AntemortemDailyRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_guide',
        'code',
        'id_gender',
        'id_age',
        'id_outlet',
        'id_purpose',
        'id_color',
        'sacrifice_date',
    ];
}
