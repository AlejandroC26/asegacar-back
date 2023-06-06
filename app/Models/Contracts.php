<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contracts extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_persons',
        'guide_number',
        'signature_date',
        'signature'
    ];

    public function person()
    {
        return $this->belongsTo(Person::class, 'id_persons');
    }
}
