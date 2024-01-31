<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostmortemInspections extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_responsable',
        'id_daily_payroll',
        'date',

        'id_head_cause',
        'head_quantity',

        'id_small_ints_cause',
        'small_ints_quantity',

        'id_large_ints_cause',
        'large_ints_quantity',

        'id_oment_cause',
        'oment_quantity',

        'id_renet_cause',
        'renet_quantity',

        'id_callus_cause',
        'callus_quantity',

        'id_liver_cause',
        'liver_quantity',

        'id_lungs_cause',
        'lungs_quantity',

        'id_legs_cause',
        'legs_quantity',

        'id_hands_cause',
        'hands_quantity',

        'id_udder_cause',
        'udder_quantity',

        'id_kidney_cause',
        'kidney_quantity',

        'id_heart_cause',
        'heart_quantity',

        'id_booklet_cause',
        'booklet_quantity',

        'id_white_viscera_cause',
        'white_viscera_quantity',
        
        'id_red_viscera_cause',
        'red_viscera_quantity',

        'id_destocking_cause',
        'destocking_quantity',

        'id_canal_cause',
        'canal_quantity',

        'other_organ',
        'id_other_cause',
        'other_quantity',
        'insp_ganglions',
    ];

    public static function onGetFieldsCause($id, $fields)
    {
        $inspection = PostmortemInspections::where('id_daily_payroll', $id)->first();
        return collect($fields)->map(function($field) use ($inspection) {
            $translations = trans('spanish');
            $cause = $inspection[$field['field']];

            $field['field'] = strtoupper($translations[$field['field']]);
            $field['cause'] = $cause->name ?? '';
            $field['sacrifice_date'] = $inspection->dailyPayroll->sacrifice_date;
            $field['id_daily_payroll'] = $inspection->id_daily_payroll;
            $field['code'] = $inspection->dailyPayroll->incomeForm->code;
            return $field;
        })->values()->toArray();
    }

    public static function onGetFieldsToMatch($id)
    {
        $inspection = PostmortemInspections::select([
            'id_daily_payroll',
            'head_quantity',
            'small_ints_quantity',
            'large_ints_quantity',
            'oment_quantity',
            'renet_quantity',
            'callus_quantity',
            'liver_quantity',
            'lungs_quantity',
            'legs_quantity',
            'hands_quantity',
            'udder_quantity',
            'kidney_quantity',
            'heart_quantity',
            'booklet_quantity',
            'white_viscera_quantity',
            'red_viscera_quantity',
            'destocking_quantity',
            'canal_quantity',
            'other_organ',
            'other_quantity',
        ])->where('id_daily_payroll', $id)
        ->first();
        return $inspection ? $inspection->toArray() : [];
    }

    public function responsable() { return $this->belongsTo(Person::class, 'id_responsable'); }
    public function dailyPayroll() { return $this->belongsTo(DailyPayroll::class, 'id_daily_payroll'); }
    public function head() { return $this->belongsTo(Causes::class, 'id_head_cause'); }
    public function small_ints() { return $this->belongsTo(Causes::class, 'id_small_ints_cause'); }
    public function large_ints() { return $this->belongsTo(Causes::class, 'id_large_ints_cause'); }
    public function oment() { return $this->belongsTo(Causes::class, 'id_oment_cause'); }
    public function renet() { return $this->belongsTo(Causes::class, 'id_renet_cause'); }
    public function callus() { return $this->belongsTo(Causes::class, 'id_callus_cause'); }
    public function liver() { return $this->belongsTo(Causes::class, 'id_liver_cause'); }
    public function lungs() { return $this->belongsTo(Causes::class, 'id_lungs_cause'); }
    public function legs() { return $this->belongsTo(Causes::class, 'id_legs_cause'); }
    public function hands() { return $this->belongsTo(Causes::class, 'id_hands_cause'); }
    public function udder() { return $this->belongsTo(Causes::class, 'id_udder_cause'); }
    public function kidney() { return $this->belongsTo(Causes::class, 'id_kidney_cause'); }
    public function heart() { return $this->belongsTo(Causes::class, 'id_heart_cause'); }
    public function booklet() { return $this->belongsTo(Causes::class, 'id_booklet_cause'); }
    public function white_viscera() { return $this->belongsTo(Causes::class, 'id_white_viscera_cause'); }
    public function red_viscera() { return $this->belongsTo(Causes::class, 'id_red_viscera_cause'); }
    public function destocking() { return $this->belongsTo(Causes::class, 'id_destocking_cause'); }
    public function canal() { return $this->belongsTo(Causes::class, 'id_canal_cause'); }
    public function other_cause() { return $this->belongsTo(Causes::class, 'id_other_cause'); }

}
