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
            $table->unsignedBigInteger('id_veterinary')->after('id_daily_payroll')->nullable();
            $table->foreign('id_veterinary')->references('id')->on('users');

            $table->time('time_entry')->after('corral_entry');
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
