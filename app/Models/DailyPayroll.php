<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyPayroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_income_form',
        'id_product_type',
        'id_outlet',
        'sacrifice_date',
        'special_order'
    ];

    public function incomeForm() 
    { 
        return $this->belongsTo(IncomeForm::class, 'id_income_form'); 
    }

    public function productType() 
    { 
        return $this->belongsTo(ProductType::class, 'id_product_type'); 
    }

    public function outlet() 
    { 
        return $this->belongsTo(Outlet::class, 'id_outlet'); 
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

    public function seizureComparisons() {
        return $this->hasMany(SeizureComparison::class, 'id_daily_payroll');
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

    public function dispatchGuideAnimal() {
        return $this->hasMany(DispatchGuideAnimal::class, 'id_daily_payroll');
    }
}
