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
        'id_administrative_assistant',
        'id_quality_assistant',
        'id_operational_manager',
        'id_assistant_veterinarian',
        'id_specie',
        'state',
    ];

    public function administrative_assistant() { 
        return $this->belongsTo(Person::class, 'id_administrative_assistant'); 
    }

    public function quality_assistant() { 
        return $this->belongsTo(Person::class, 'id_quality_assistant'); 
    }

    public function operational_manager() { 
        return $this->belongsTo(Person::class, 'id_operational_manager'); 
    }

    public function assistant_veterinarian() { 
        return $this->belongsTo(Person::class, 'id_assistant_veterinarian'); 
    }

    public function quality_manager() { 
        return $this->belongsTo(Person::class, 'id_quality_manager'); 
    }

    public function specie() { 
        return $this->belongsTo(Specie::class, 'id_specie'); 
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
