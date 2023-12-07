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

    public function antemortemInspections() {
        return $this->hasMany(AntemortemInspection::class, 'id_daily_payroll');
    }

    public function inspectionsSuspiciousAnimals() {
        return $this->hasMany(InspectionSuspiciousAnimal::class, 'id_daily_payroll');
    }

    public function parturiantFemales() {
        return $this->hasMany(ParturientFemales::class, 'id_daily_payroll');
    }

    public function suspiciousAnimals() {
        return $this->hasMany(SuspiciousAnimals::class, 'id_daily_payroll');
    }

    public function emergencyCoilEntry() {
        return $this->hasMany(EmergencyCoilEntry::class, 'id_daily_payroll');
    }

    public function benefitOrders() {
        return $this->hasMany(FormBenefitOrder::class, 'id_daily_payroll');
    }

    public function postmortemInspections() {
        return $this->hasMany(PostmortemInspections::class, 'id_daily_payroll');
    }

    public function zeroGutsTolerance() {
        return $this->hasMany(ZeroGutsTolerance::class, 'id_daily_payroll');
    }

    public function zeroToleranceInspection() {
        return $this->hasMany(ZeroToleranceInspection::class, 'id_daily_payroll');
    }

    public function channelConditioning() {
        return $this->hasMany(ChannelConditioning::class, 'id_daily_payroll');
    }

    public function visceraDispatch() {
        return $this->hasMany(VisceraDispatch::class, 'id_daily_payroll');
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
