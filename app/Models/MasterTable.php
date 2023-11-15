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
        'id_guide',
        'id_master_type',
        'id_responsable',
        'id_verified_by',
        'id_supervised_by',
        'id_elaborated_by',
        'id_specie',
        'state',
    ];

    public function responsable() { 
        return $this->belongsTo(Person::class, 'id_responsable'); 
    }
    public function specie() { 
        return $this->belongsTo(Specie::class, 'id_specie'); 
    }

    public function verified_by() { 
        return $this->belongsTo(Person::class, 'id_verified_by'); 
    }
    public function supervised_by() { 
        return $this->belongsTo(Person::class, 'id_supervised_by'); 
    }
    public function elaborated_by() { 
        return $this->belongsTo(Person::class, 'id_elaborated_by'); 
    }

    public function type() {
        return $this->belongsTo(MasterType::class, 'id_master_type');
    }

    public function benefitOrders() {
        return $this->hasMany(FormBenefitOrder::class, 'id_master', 'id');
    }
    
    public function postMortemInspections() {
        return $this->hasMany(PostmortemInspections::class, 'id_master', 'id');
    }

    public function zeroGutsTolerances() {
        return $this->hasMany(ZeroGutsTolerance::class, 'id_master', 'id');
    }

    public function zeroToleranceInspections() {
        return $this->hasMany(ZeroGutsTolerance::class, 'id_master', 'id');
    }

    public function channelConditions() {
        return $this->hasMany(ChannelConditioning::class, 'id_master', 'id');
    }
    
    public function visceraDispatches() {
        return $this->hasMany(VisceraDispatch::class, 'id_master', 'id');
    }

    public function seizureComparisons() {
        return $this->hasMany(SeizureComparison::class, 'id_master', 'id');
    }
    
}
