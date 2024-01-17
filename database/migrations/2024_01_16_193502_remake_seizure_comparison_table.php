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
        Schema::dropIfExists('seizure_comparison');
        Schema::create('seizure_comparison', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_responsable')->nullable();
            $table->foreign('id_responsable')->references('id')->on('persons');

            $table->unsignedBigInteger('id_supervised_by')->nullable();
            $table->foreign('id_supervised_by')->references('id')->on('persons');

            $table->unsignedBigInteger('id_daily_payroll')->comment('Id de animal');
            $table->foreign('id_daily_payroll')->references('id')->on('daily_payrolls');

            $table->date('date');

            $table->string('head_quantity');
            $table->string('small_ints_quantity');
            $table->string('large_ints_quantity');
            $table->string('oment_quantity');
            $table->string('renet_quantity');
            $table->string('callus_quantity');
            $table->string('liver_quantity');
            $table->string('lungs_quantity');
            $table->string('legs_quantity');
            $table->string('hands_quantity');
            $table->string('udder_quantity');
            $table->string('kidney_quantity');
            $table->string('heart_quantity');
            $table->string('booklet_quantity');
            $table->string('white_viscera_quantity');
            $table->string('red_viscera_quantity');
            $table->string('destocking_quantity');
            $table->string('canal_quantity');
            $table->string('other_organ')->nullable();
            $table->string('other_quantity')->nullable();

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
        //
    }
};
