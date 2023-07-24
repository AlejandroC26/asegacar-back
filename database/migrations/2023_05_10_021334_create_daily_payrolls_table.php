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
        Schema::create('daily_payrolls', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_dp_master')->comment('Id de maestra');
            $table->foreign('id_dp_master')->references('id')->on('daily_payroll_master');

            $table->unsignedBigInteger('id_outlet')->comment('Id de expendio');
            $table->foreign('id_outlet')->references('id')->on('outlets');

            $table->unsignedBigInteger('id_gender')->comment('Id del género');
            $table->foreign('id_gender')->references('id')->on('genders');

            $table->unsignedBigInteger('id_color')->comment('Id de color');
            $table->foreign('id_color')->references('id')->on('colors');

            $table->integer('amount');
            
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
        Schema::dropIfExists('daily_payrolls');
    }
};
