<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyMatrix extends Model
{
    use HasFactory;

    public static function onGetMakeViewSQL() {
        return "CREATE VIEW `daily_matrix_view` AS 
            SELECT 
                `dp`.`id` AS `id`,
                `guides`.`date_entry` AS `date_entry`,
                `if`.`code` AS `asigned_code`,
                `guides`.`code` AS `no_guide`,
                `guides`.`time_entry` AS `time_entry`,
                `ages`.`description` AS `age`,
                `genders`.`id` AS `id_gender`,
                `genders`.`name` AS `gender`,
                `outlets`.`code` AS `outlet`,
                `purposes`.`name` AS `purpose`,
                `colors`.`name` AS `color`,
                `dp`.`sacrifice_date` AS `sacrifice_date`,
                `ai`.`corral_entry` AS `corral_entry`,
                `guides`.`id_buyer` AS `id_buyer`,
                `guides`.`id_owner` AS `id_owner`,
                `owner`.`fullname` AS `owner`,
                `owner`.`document` AS `owner_document`,
                `buyer`.`fullname` AS `buyer`,
                `guides`.`establishment_name` AS `establishment_name`,
                `source_city`.`name` AS `source_city`,
                `source_department`.`name` AS `source_department`
            FROM
                (((((((((((`daily_payrolls` `dp`
                LEFT JOIN `income_forms` `if` ON (`if`.`id` = `dp`.`id_income_form`)
                LEFT JOIN `antemortem_inspection` `ai` ON (`ai`.`id_daily_payroll` = `dp`.`id`)
                LEFT JOIN `daily_payroll_master` `dpm` ON ((`dpm`.`id` = `if`.`id_dp_master`)))
                LEFT JOIN `guides` ON ((`guides`.`id` = `if`.`id_guide`)))
                LEFT JOIN `purposes` ON ((`purposes`.`id` = `if`.`id_purpose`)))
                LEFT JOIN `ages` ON ((`ages`.`id` = `if`.`id_age`)))
                LEFT JOIN `colors` ON ((`colors`.`id` = `if`.`id_color`)))
                LEFT JOIN `genders` ON ((`genders`.`id` = `if`.`id_gender`)))
                LEFT JOIN `outlets` ON ((`outlets`.`id` = `dp`.`id_outlet`)))
                LEFT JOIN `cities` `source_city` ON ((`source_city`.`id` = `guides`.`id_source`)))
                LEFT JOIN `departments` `source_department` ON ((`source_department`.`id` = `source_city`.`id_department`)))
                LEFT JOIN `persons` `buyer` ON ((`buyer`.`id` = `guides`.`id_buyer`)))
                LEFT JOIN `persons` `owner` ON ((`owner`.`id` = `guides`.`id_owner`)))";
    }
}
