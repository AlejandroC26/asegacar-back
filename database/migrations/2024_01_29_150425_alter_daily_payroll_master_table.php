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
        Schema::table('daily_payroll_master', function (Blueprint $table) {
            $table->dropForeign(['id_responsable']);
        });

        Schema::table('daily_payroll_master', function (Blueprint $table) {
            $table->renameColumn('id_responsable', 'id_administrative_assistant');
        });

        Schema::table('daily_payroll_master', function (Blueprint $table) {
            $table->foreign('id_administrative_assistant')->references('id')->on('persons');

            $table->unsignedBigInteger('id_quality_assistant')->after('id_administrative_assistant')->nullable();
            $table->foreign('id_quality_assistant')->references('id')->on('persons');

            $table->unsignedBigInteger('id_operational_manager')->after('id_administrative_assistant')->nullable();
            $table->foreign('id_operational_manager')->references('id')->on('persons');

            $table->unsignedBigInteger('id_assistant_veterinarian')->after('id_administrative_assistant')->nullable();
            $table->foreign('id_assistant_veterinarian')->references('id')->on('persons');
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
