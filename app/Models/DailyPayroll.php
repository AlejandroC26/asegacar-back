<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyPayroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_master',
        'id_outlet',
        'id_gender',
        'id_color',
        'amount',
        'special_order',
    ];

    public function master() { return $this->belongsTo(MasterTable::class, 'id_master'); }
    public function outlet() { return $this->belongsTo(Outlet::class, 'id_outlet'); }
    public function gender() { return $this->belongsTo(Gender::class, 'id_gender'); }
    public function color() { return $this->belongsTo(Color::class, 'id_color'); }

}
