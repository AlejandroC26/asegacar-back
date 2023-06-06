<?php
namespace App\Helpers;

use Carbon\Carbon;

class FormatDateHelper
{

    public static function onGetCurrentDate()
    {
        $cur_date = Carbon::parse(now());
        $dayOfWek = FormatDateHelper::onNumberToDay($cur_date->dayOfWeek);
        $month = self::onNumberToMonth(intval($cur_date->format('m')));
        $year = $cur_date->format('Y');
        return  mb_strtoupper($dayOfWek.' '.$cur_date->format('d').' '.$month.' '.$year);
    }

    public static function onNumberToLetter($number){
        $aUnits = array(
            1 => 'uno',
            2 => 'dos',
            3 => 'tres',
            4 => 'cuatro',
            5 => 'cinco',
            6 => 'seis',
            7 => 'siete',
            8 => 'ocho',
            9 => 'nueve',
            10 => 'diez',
            11 => 'once',
            12 => 'doce',
            13 => 'trece',
            14 => 'catorce',
            15 => 'quince',
            16 => 'dieciséis',
            17 => 'diecisiete',
            18 => 'dieciocho',
            19 => 'diecinueve',
            20 => 'veinte',
            21 => 'veintiuno',
            22 => 'veintidós',
            23 => 'veintitrés',
            24 => 'veinticuatro',
            25 => 'veinticinco',
            26 => 'veintiséis',
            27 => 'veintisiete',
            28 => 'veintiocho',
            29 => 'veintinueve',
            30 => 'treinta',
            31 => 'treinta y uno'
        );
        return $aUnits[$number];
    }

    public static function onNumberToDay($number) {
        $aUnits = array(
            0 => 'Domingo',
            1 => 'Lunes',
            2 => 'Martes',
            3 => 'Miércoles',
            4 => 'Jueves',
            5 => 'Viernes',
            6 => 'Sábado',
        );
        return $aUnits[$number];
    }

    public static function onNumberToMonth($number){
        $aMonths = [
            1 => 'enero',
            2 => 'febrero',
            3 => 'marzo',
            4 => 'abril',
            5 => 'mayo',
            6 => 'junio',
            7 => 'julio',
            8 => 'agosto',
            9 => 'septiembre',
            10 => 'octubre',
            11 => 'noviembre',
            12 => 'diciembre'
        ];
        return $aMonths[$number];
    }
}

