<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'guide_number',
        'total_males',
        'total_females',
        'date_entry',
        'time_entry',
        'benefit_date',
        'yard_sacrificed_time',
        'farm_name',
        'gender',
        'color',
        'id_owner',
        'id_buyer',
        'id_age',
        'id_purpose',
        'id_outlet',
        'id_city',
    ];
}
