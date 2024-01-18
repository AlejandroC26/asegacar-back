<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralParam extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'value'
    ];

    public static function onGetResponsable() {
        $id_responsable = GeneralParam::where('name', 'id_responsable')->first();
        return $id_responsable->value ?? null;
    }
    
    public static function onGetVerifiedBy() {
        $id_verified_by = GeneralParam::where('name', 'id_verified_by')->first();
        return $id_verified_by->value ?? null;
    }
    
    public static function onGetElaboratedBy() {
        $id_elaborated_by = GeneralParam::where('name', 'id_elaborated_by')->first();
        return $id_elaborated_by->value ?? null;
    }

    public static function onGetSupervisedBy() {
        $id_supervised_by = GeneralParam::where('name', 'id_supervised_by')->first();
        return $id_supervised_by->value ?? null;
    }

    public static function onGetVeterinary() {
        $id_veterinary = GeneralParam::where('name', 'id_veterinary')->first();
        return $id_veterinary->value ?? null;
    }
}
