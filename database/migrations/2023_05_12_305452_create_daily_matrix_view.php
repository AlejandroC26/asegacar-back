<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement($this->dropView());
        \DB::statement($this->createView());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    private function createView(): string
    {
        return <<<SQL
            CREATE VIEW `daily_matrix_view` AS 
                SELECT 
                    `guides`.`date_entry` AS `date_entry`,
                    `dp`.`code` AS `asigned_code`,
                    `guides`.`code` AS `no_guide`,
                    `guides`.`time_entry` AS `time_entry`,
                    `ages`.`description` AS `age`,
                    `genders`.`id` AS `id_gender`,
                    `genders`.`name` AS `gender`,
                    `outlets`.`code` AS `outlet`,
                    `purposes`.`name` AS `purpose`,
                    `colors`.`name` AS `color`,
                    `dp`.`sacrifice_date` AS `sacrifice_date`,
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
                    LEFT JOIN `daily_payroll_master` `dpm` ON ((`dpm`.`id` = `dp`.`id_dp_master`)))
                    LEFT JOIN `guides` ON ((`guides`.`id` = `dpm`.`id_guide`)))
                    LEFT JOIN `purposes` ON ((`purposes`.`id` = `dp`.`id_purpose`)))
                    LEFT JOIN `ages` ON ((`ages`.`id` = `dp`.`id_age`)))
                    LEFT JOIN `colors` ON ((`colors`.`id` = `dp`.`id_color`)))
                    LEFT JOIN `genders` ON ((`genders`.`id` = `dp`.`id_gender`)))
                    LEFT JOIN `outlets` ON ((`outlets`.`id` = `dp`.`id_outlet`)))
                    LEFT JOIN `cities` `source_city` ON ((`source_city`.`id` = `guides`.`id_source`)))
                    LEFT JOIN `departments` `source_department` ON ((`source_department`.`id` = `source_city`.`id_department`)))
                    LEFT JOIN `persons` `buyer` ON ((`buyer`.`id` = `guides`.`id_buyer`)))
                    LEFT JOIN `persons` `owner` ON ((`owner`.`id` = `guides`.`id_owner`)))
            SQL;
    }
    
    /**
        * Reverse the migrations.
        *
        * @return void
        */
    private function dropView(): string
    {
        return <<<SQL
            DROP VIEW IF EXISTS daily_matrix_view;
        SQL;
    }
};
