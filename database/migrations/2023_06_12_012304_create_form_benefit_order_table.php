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
        Schema::create('form_benefit_orders', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_master')->comment('Id de matriz');
            $table->foreign('id_master')->references('id')->on('master_table');

            $table->unsignedBigInteger('id_daily_payroll')->nullable()->comment('Id de registro diario');
            $table->foreign('id_daily_payroll')->references('id')->on('daily_payrolls');

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
        Schema::dropIfExists('form_benefit_order');
    }
};
