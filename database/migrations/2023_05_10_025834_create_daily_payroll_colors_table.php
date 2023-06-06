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
        Schema::create('daily_payroll_colors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_daily_payroll')->comment('Id del color');
            $table->foreign('id_daily_payroll')->references('id')->on('daily_payrolls');
            $table->unsignedBigInteger('id_color')->comment('Id del color');
            $table->foreign('id_color')->references('id')->on('colors');
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
        Schema::dropIfExists('daily_payroll_colors');
    }
};
