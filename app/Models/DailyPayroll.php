<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyPayroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_outlet',
        'id_city',
        'total_males',
        'total_females',
        'special_order',
        'benefit_date',
    ];
}
