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
                    guides.date_entry, 
                    adr.code as asigned_code,
                    guides. code as no_guide,
                    guides.time_entry,
                    ages.description as age,
                    genders.id as id_gender,
                    genders.name as gender,
                    outlets.code as outlet,
                    purposes.name as purpose,
                    colors.name as color,
                    outlets.code as no_outlet,
                    adr.sacrifice_date,
                    guides.id_buyer,
                    guides.id_owner,
                    owner.fullname as owner,
                    owner.document as owner_document,
                    buyer.fullname as buyer,
                    guides.establishment_name,
                    source_city.name as source_city,
                    source_department.name as source_department
                FROM guides
                left join antemortem_daily_records adr on adr.id_guide = guides.id
                left join genders on genders.id = adr.id_gender
                left join ages on ages.id = adr.id_age
                left join purposes on purposes.id = adr.id_purpose
                left join colors on colors.id = adr.id_color
                left join outlets on outlets.id = adr.id_outlet
                left join cities source_city on source_city.id = guides.id_source
                left join departments source_department on source_department.id = source_city.id_department
                left join persons as buyer on buyer.id = guides.id_buyer
                left join persons as owner on owner.id = guides.id_owner
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
