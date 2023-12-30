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

            $table->unsignedBigInteger('id_income_form')->comment('Id del ingreso');
            $table->foreign('id_income_form')->references('id')->on('income_forms');

            $table->unsignedBigInteger('id_product_type')->comment('Id del tipo de producto');
            $table->foreign('id_product_type')->references('id')->on('product_types');

            $table->unsignedBigInteger('id_outlet')->nullable()->comment('Id de expendio');
            $table->foreign('id_outlet')->references('id')->on('outlets');
            
            $table->date('sacrifice_date')->nullable()->comment('Fecha de sacrificio');
            $table->text('special_order')->nullable();

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
