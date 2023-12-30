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
        Schema::create('income_forms', function (Blueprint $table) {
            $table->id();

            $table->string('code');

            $table->unsignedBigInteger('id_dp_master')->comment('Id de maestra');
            $table->foreign('id_dp_master')->references('id')->on('daily_payroll_master');

            $table->unsignedBigInteger('id_guide')->nullable()->comment('Id guía');
            $table->foreign('id_guide')->references('id')->on('guides');

            $table->unsignedBigInteger('id_gender')->comment('Id del género');
            $table->foreign('id_gender')->references('id')->on('genders');

            $table->unsignedBigInteger('id_color')->comment('Id de color');
            $table->foreign('id_color')->references('id')->on('colors');

            $table->unsignedBigInteger('id_age')->comment('Id de edad');
            $table->foreign('id_age')->references('id')->on('ages');

            $table->unsignedBigInteger('id_purpose')->comment('Id de propósito');
            $table->foreign('id_purpose')->references('id')->on('purposes');

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
        Schema::dropIfExists('income_forms');
    }
};
