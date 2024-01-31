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
        Schema::table('master_table', function (Blueprint $table) {
            $table->dropForeign(['id_responsable']);
            $table->dropForeign(['id_verified_by']);
            $table->dropForeign(['id_supervised_by']);
            $table->dropForeign(['id_elaborated_by']);
        });

        Schema::table('master_table', function (Blueprint $table) {
            $table->renameColumn('id_responsable', 'id_administrative_assistant');
            $table->renameColumn('id_verified_by', 'id_quality_assistant');
            $table->renameColumn('id_supervised_by', 'id_operational_manager');
            $table->renameColumn('id_elaborated_by', 'id_assistant_veterinarian');
        });

        Schema::table('master_table', function (Blueprint $table) {

            $table->foreign('id_administrative_assistant')->references('id')->on('persons');
            $table->foreign('id_quality_assistant')->references('id')->on('persons');
            $table->foreign('id_operational_manager')->references('id')->on('persons');
            $table->foreign('id_assistant_veterinarian')->references('id')->on('persons');

            $table->unsignedBigInteger('id_quality_manager')->after('id_assistant_veterinarian')->nullable();
            $table->foreign('id_quality_manager')->references('id')->on('persons');
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
