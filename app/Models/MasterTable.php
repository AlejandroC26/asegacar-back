<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterTable extends Model
{
    use HasFactory;

    public $table = 'master_table';

    protected $fillable = [
        'date',
        'id_master_type',
        'id_responsable',
        'id_verified_by',
        'id_supervised_by',
        'id_elaborated_by',
        'species',
    ];

    public function responsable() { return $this->belongsTo(Person::class, 'id_responsable'); }
    public function verified_by() { return $this->belongsTo(Person::class, 'id_verified_by'); }
    public function supervised_by() { return $this->belongsTo(Person::class, 'id_supervised_by'); }
    public function elaborated_by() { return $this->belongsTo(Person::class, 'id_elaborated_by'); }

    public function type()
    {
        return $this->belongsTo(MasterType::class, 'id_master_type');
    }
}
