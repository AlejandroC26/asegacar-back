<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'name',
        'id_department'
    ];

    public function department() { 
        return $this->belongsTo(Department::class, 'id_department'); 
    }
}
