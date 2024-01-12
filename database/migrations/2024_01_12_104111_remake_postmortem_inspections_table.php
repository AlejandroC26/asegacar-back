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
        Schema::dropIfExists('postmortem_inspections');
        Schema::create('postmortem_inspections', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_responsable')->nullable();
            $table->foreign('id_responsable')->references('id')->on('persons');

            $table->unsignedBigInteger('id_daily_payroll')->comment('Id de animal');
            $table->foreign('id_daily_payroll')->references('id')->on('daily_payrolls');

            $table->date('date');

            $table->unsignedBigInteger('id_head_cause')->nullable();
            $table->foreign('id_head_cause')->references('id')->on('causes');
            $table->string('head_quantity');

            $table->unsignedBigInteger('id_small_ints_cause')->nullable();
            $table->foreign('id_small_ints_cause')->references('id')->on('causes');
            $table->string('small_ints_quantity');

            $table->unsignedBigInteger('id_large_ints_cause')->nullable();
            $table->foreign('id_large_ints_cause')->references('id')->on('causes');
            $table->string('large_ints_quantity');
            
            $table->unsignedBigInteger('id_oment_cause')->nullable();
            $table->foreign('id_oment_cause')->references('id')->on('causes');
            $table->string('oment_quantity');

            $table->unsignedBigInteger('id_renet_cause')->nullable();
            $table->foreign('id_renet_cause')->references('id')->on('causes');
            $table->string('renet_quantity');

            $table->unsignedBigInteger('id_callus_cause')->nullable();
            $table->foreign('id_callus_cause')->references('id')->on('causes');
            $table->string('callus_quantity');

            $table->unsignedBigInteger('id_liver_cause')->nullable();
            $table->foreign('id_liver_cause')->references('id')->on('causes');
            $table->string('liver_quantity');

            $table->unsignedBigInteger('id_lungs_cause')->nullable();
            $table->foreign('id_lungs_cause')->references('id')->on('causes');
            $table->string('lungs_quantity');

            $table->unsignedBigInteger('id_legs_cause')->nullable();
            $table->foreign('id_legs_cause')->references('id')->on('causes');
            $table->string('legs_quantity');

            $table->unsignedBigInteger('id_hands_cause')->nullable();
            $table->foreign('id_hands_cause')->references('id')->on('causes');
            $table->string('hands_quantity');

            $table->unsignedBigInteger('id_udder_cause')->nullable();
            $table->foreign('id_udder_cause')->references('id')->on('causes');
            $table->string('udder_quantity');

            $table->unsignedBigInteger('id_kidney_cause')->nullable();
            $table->foreign('id_kidney_cause')->references('id')->on('causes');
            $table->string('kidney_quantity');

            $table->unsignedBigInteger('id_heart_cause')->nullable();
            $table->foreign('id_heart_cause')->references('id')->on('causes');
            $table->string('heart_quantity');

            $table->unsignedBigInteger('id_booklet_cause')->nullable();
            $table->foreign('id_booklet_cause')->references('id')->on('causes');
            $table->string('booklet_quantity');

            $table->unsignedBigInteger('id_white_viscera_cause')->nullable();
            $table->foreign('id_white_viscera_cause')->references('id')->on('causes');
            $table->string('white_viscera_quantity');

            $table->unsignedBigInteger('id_red_viscera_cause')->nullable();
            $table->foreign('id_red_viscera_cause')->references('id')->on('causes');
            $table->string('red_viscera_quantity');

            $table->unsignedBigInteger('id_destocking_cause')->nullable();
            $table->foreign('id_destocking_cause')->references('id')->on('causes');
            $table->string('destocking_quantity');

            $table->unsignedBigInteger('id_canal_cause')->nullable();
            $table->foreign('id_canal_cause')->references('id')->on('causes');
            $table->string('canal_quantity');

            $table->string('other_organ')->nullable();
            $table->unsignedBigInteger('id_other_cause')->nullable();
            $table->foreign('id_other_cause')->references('id')->on('causes')->nullable();
            $table->string('other_quantity')->nullable();
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

    }
};
