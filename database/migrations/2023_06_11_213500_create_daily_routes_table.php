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
        Schema::create('daily_routes', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_route')->comment('Id de la ruta');
            $table->foreign('id_route')->references('id')->on('routes');

            $table->unsignedBigInteger('id_daily_payroll')->comment('Id de animal');
            $table->foreign('id_daily_payroll')->references('id')->on('daily_payrolls');

            $table->integer('quantity');
            $table->longText('orders')->nullable();
            $table->date('date');
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
        Schema::dropIfExists('daily_routes');
    }
};
