<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyPayroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'id_dp_master',
        'id_outlet',
        'id_gender',
        'id_color',
        'id_age',
        'id_purpose',
        'sacrifice_date',
        'special_order'
    ];

    public function master() 
    { 
        return $this->belongsTo(DailyPayrollMaster::class, 'id_dp_master'); 
    }
    
    public function outlet() 
    { 
        return $this->belongsTo(Outlet::class, 'id_outlet'); 
    }
    public function gender() 
    { 
        return $this->belongsTo(Gender::class, 'id_gender'); 
    }
    public function color() 
    { 
        return $this->belongsTo(Color::class, 'id_color'); 
    }

}
