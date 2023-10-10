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
        Schema::create('parturient_females', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('time');

            $table->unsignedBigInteger('id_supervisor')->nullable();
            $table->foreign('id_supervisor')->references('id')->on('users');

            $table->unsignedBigInteger('id_responsable')->nullable();
            $table->foreign('id_responsable')->references('id')->on('users');

            $table->unsignedBigInteger('id_veterinary')->nullable();
            $table->foreign('id_veterinary')->references('id')->on('users');

            $table->unsignedBigInteger('id_owner')->nullable();
            $table->foreign('id_owner')->references('id')->on('users');

            $table->time('delivery_time');
            $table->text('iron');
            $table->text('corral_location');

            $table->unsignedBigInteger('id_location')->comment('Ciudad de destino');
            $table->foreign('id_location')->references('id')->on('cities');

            $table->unsignedBigInteger('id_daily_payroll')->comment('Id de animal');
            $table->foreign('id_daily_payroll')->references('id')->on('daily_payrolls');

            $table->integer('weight');
            $table->integer('temperature');
            $table->integer('heart_frequency');
            $table->integer('respiratory_frequency');
            $table->text('findings')->nullable();
            $table->text('final_definition_feto')->nullable();
            $table->longText('observations')->nullable();

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
        Schema::dropIfExists('parturient_females');
    }
};
