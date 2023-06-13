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
        Schema::create('postmortem_inspections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_master')->comment('Id de matriz');
            $table->foreign('id_master')->references('id')->on('master_table');
            $table->unsignedBigInteger('id_antemortem_daily_record')->comment('Id de animal');
            $table->foreign('id_antemortem_daily_record')->references('id')->on('antemortem_daily_records');

            $table->unsignedBigInteger('id_intestines_cause')->nullable();
            $table->foreign('id_intestines_cause')->references('id')->on('causes');
            $table->integer('intestines_quantity');

            $table->unsignedBigInteger('id_livers_cause')->nullable();
            $table->foreign('id_livers_cause')->references('id')->on('causes');
            $table->integer('liver_quantity');

            $table->unsignedBigInteger('id_lungs_cause')->nullable();
            $table->foreign('id_lungs_cause')->references('id')->on('causes');
            $table->integer('lungs_quantity');

            $table->unsignedBigInteger('id_udders_cause')->nullable();
            $table->foreign('id_udders_cause')->references('id')->on('causes');
            $table->integer('udders_quantity');

            $table->unsignedBigInteger('id_legs_cause')->nullable();
            $table->foreign('id_legs_cause')->references('id')->on('causes');
            $table->integer('legs_quantity');

            $table->unsignedBigInteger('id_purges_cause')->nullable();
            $table->foreign('id_purges_cause')->references('id')->on('causes');
            $table->integer('purges_quantity');

            $table->string('other_organ')->nullable();
            $table->unsignedBigInteger('id_other_cause')->nullable();
            $table->foreign('id_other_cause')->references('id')->on('causes')->nullable();
            $table->integer('other_quantity')->nullable();
            $table->string('insp_ganglions')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('postmortem_inspections');
    }
};
