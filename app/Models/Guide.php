<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'no_animals',
        'date_entry',
        'time_entry',
        'state',
        'id_owner',
        'id_buyer',
        'id_source',
        'id_destination',
        'establishment_name',
        'consecutive',
        'id_specie',
        'file_attached'
    ];

        
    public function owner() { 
        return $this->belongsTo(Person::class, 'id_owner'); 
    }

    public function buyer() { 
        return $this->belongsTo(Person::class, 'id_buyer'); 
    }

    public function source() { 
        return $this->belongsTo(City::class, 'id_source'); 
    }

    public function destination () { 
        return $this->belongsTo(City::class, 'id_destination'); 
    }
}
