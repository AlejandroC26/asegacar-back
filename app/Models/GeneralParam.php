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

    public static function onGetGeneralParamByName($sName) {
        $general_param = GeneralParam::where(['name' => $sName])->first();
        return $general_param?->value;
    }
}
