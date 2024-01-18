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
        Schema::table('antemortem_inspection', function (Blueprint $table) {
            $table->removeColumn('time_entry');
            $table->text('findings_and_observations')->after('rest_time')->nullable();
            $table->text('final_dictament')->after('rest_time')->nullable();
            $table->text('cause_for_seizure')->after('rest_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
