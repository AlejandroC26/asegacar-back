<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SeizureComparison extends Model
{
    use HasFactory;

    public $table = 'seizure_comparison';

    protected $fillable = [
        'date',
        'id_responsable',
        'id_supervised_by',
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
    ];

    public static function onGetComparison($id)
    {
        return DB::table('postmortem_inspections as pmi')
            ->join('seizure_comparison as sc', 'pmi.id_daily_payroll', '=', 'sc.id_daily_payroll')
            ->where([
                ['pmi.head_quantity', '=', DB::raw('CAST(sc.head_quantity AS CHAR)')],
                ['pmi.small_ints_quantity', '=', DB::raw('CAST(sc.small_ints_quantity AS CHAR)')],
                ['pmi.large_ints_quantity', '=', DB::raw('CAST(sc.large_ints_quantity AS CHAR)')],
                ['pmi.oment_quantity', '=', DB::raw('CAST(sc.oment_quantity AS CHAR)')],
                ['pmi.renet_quantity', '=', DB::raw('CAST(sc.renet_quantity AS CHAR)')],
                ['pmi.callus_quantity', '=', DB::raw('CAST(sc.callus_quantity AS CHAR)')],
                ['pmi.liver_quantity', '=', DB::raw('CAST(sc.liver_quantity AS CHAR)')],
                ['pmi.lungs_quantity', '=', DB::raw('CAST(sc.lungs_quantity AS CHAR)')],
                ['pmi.legs_quantity', '=', DB::raw('CAST(sc.legs_quantity AS CHAR)')],
                ['pmi.hands_quantity', '=', DB::raw('CAST(sc.hands_quantity AS CHAR)')],
                ['pmi.udder_quantity', '=', DB::raw('CAST(sc.udder_quantity AS CHAR)')],
                ['pmi.kidney_quantity', '=', DB::raw('CAST(sc.kidney_quantity AS CHAR)')],
                ['pmi.heart_quantity', '=', DB::raw('CAST(sc.heart_quantity AS CHAR)')],
                ['pmi.booklet_quantity', '=', DB::raw('CAST(sc.booklet_quantity AS CHAR)')],
                ['pmi.white_viscera_quantity', '=', DB::raw('CAST(sc.white_viscera_quantity AS CHAR)')],
                ['pmi.red_viscera_quantity', '=', DB::raw('CAST(sc.red_viscera_quantity AS CHAR)')],
                ['pmi.destocking_quantity', '=', DB::raw('CAST(sc.destocking_quantity AS CHAR)')],
                ['pmi.canal_quantity', '=', DB::raw('CAST(sc.canal_quantity AS CHAR)')]
            ])->where('pmi.id_daily_payroll', $id)
            ->select(
                'pmi.id_daily_payroll',
                'pmi.head_quantity',
                'pmi.small_ints_quantity',
                'pmi.large_ints_quantity',
                'pmi.oment_quantity',
                'pmi.renet_quantity',
                'pmi.callus_quantity',
                'pmi.liver_quantity',
                'pmi.lungs_quantity',
                'pmi.legs_quantity',
                'pmi.hands_quantity',
                'pmi.udder_quantity',
                'pmi.kidney_quantity',
                'pmi.heart_quantity',
                'pmi.booklet_quantity',
                'pmi.white_viscera_quantity',
                'pmi.red_viscera_quantity',
                'pmi.destocking_quantity',
                'pmi.canal_quantity',
                'pmi.other_organ',
                'pmi.other_quantity'
            )
            ->first();
    }

    public static function onGetMatches($comparison)
    {
        $matches = [];
        foreach ($comparison as $field => $value) {
            // Excluir el campo 'id_daily_payroll' ya que se utiliza como base de la comparación
            if ($field !== 'id_daily_payroll' && !empty($value)) {
                $matches[] = str_replace('_quantity', '', $field);
            }
        }
        return $matches;
    }

    public function dailyPayroll() 
    { 
        return $this->belongsTo(DailyPayroll::class, 'id_daily_payroll'); 
    }

    public function responsable() { 
        return $this->belongsTo(Person::class, 'id_responsable'); 
    }

    public function supervised_by() { 
        return $this->belongsTo(Person::class, 'id_supervised_by'); 
    }
}
