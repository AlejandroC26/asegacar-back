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
        Schema::create('dispatch_guides', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->date('sacrifice_date')->comment('Fecha de sacrificio');
            $table->integer('average_temperature');
            $table->date('closing_date');
            $table->time('closing_time');
            $table->enum('dispatch_time', ['AM', 'PM']);

            $table->unsignedBigInteger('id_outlet')->nullable()->comment('Id de expendio');
            $table->foreign('id_outlet')->references('id')->on('outlets');

            $table->unsignedBigInteger('id_invima_code')->comment('Id código invima');
            $table->foreign('id_invima_code')->references('id')->on('invima_codes');

            $table->unsignedBigInteger('id_vehicle')->comment('Vehículo');
            $table->foreign('id_vehicle')->references('id')->on('vehicles');

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
        Schema::dropIfExists('dispatch_guides');
    }
};
