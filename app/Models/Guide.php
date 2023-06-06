<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'date_entry',
        'time_entry',
        'state',
        'id_owner',
        'id_buyer',
        'id_source',
        'id_destination',
        'establishment_name'
    ];
}
