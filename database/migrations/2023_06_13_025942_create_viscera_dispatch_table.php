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
        Schema::create('viscera_dispatch', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_master')->comment('Id de matriz');
            $table->foreign('id_master')->references('id')->on('master_table');
            $table->unsignedBigInteger('id_daily_payroll')->comment('Id de animal');
            $table->foreign('id_daily_payroll')->references('id')->on('daily_payrolls');
            $table->string('head')->nullable();
            $table->string('small_ints')->nullable();
            $table->string('large_ints')->nullable();
            $table->string('panolon')->nullable();
            $table->string('rennet')->nullable();
            $table->string('callus')->nullable();
            $table->string('liver')->nullable();
            $table->string('lung')->nullable();
            $table->string('legs')->nullable();
            $table->string('hands')->nullable();
            $table->string('udders')->nullable();
            $table->string('booklet')->nullable();
            $table->text('observations')->nullable();

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
        Schema::dropIfExists('viscera_dispatch');
    }
};
