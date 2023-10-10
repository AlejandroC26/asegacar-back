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
        Schema::create('antemortem_inspection', function (Blueprint $table) {
            $table->id();
            $table->integer('corral_number');

            $table->unsignedBigInteger('id_daily_payroll')->comment('Id de animal');
            $table->foreign('id_daily_payroll')->references('id')->on('daily_payrolls');

            $table->dateTime('corral_entry');

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
        Schema::dropIfExists('antemortem_inspection');
    }
};
