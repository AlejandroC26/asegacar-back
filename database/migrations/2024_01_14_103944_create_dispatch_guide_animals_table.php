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
        Schema::create('dispatch_guide_animals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_dispatch_guide');
            $table->foreign('id_dispatch_guide')->references('id')->on('dispatch_guides');

            $table->unsignedBigInteger('id_daily_payroll');
            $table->foreign('id_daily_payroll')->references('id')->on('daily_payrolls');

            $table->float('amount', 8, 2);

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
        Schema::dropIfExists('dispatch_guide_animals');
    }
};
