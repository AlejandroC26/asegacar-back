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
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->integer('code');
            $table->integer('guide_number');
            $table->integer('total_males');
            $table->integer('total_females');
            $table->date('date_entry');
            $table->time('time_entry');
            $table->date('benefit_date');
            $table->time('yard_sacrificed_time');
            $table->text('farm_name');
            $table->enum('gender', ['Macho', 'Hembra']);

            $table->unsignedBigInteger('id_color')->comment('Id del color');
            $table->foreign('id_color')->references('id')->on('persons');
            
            

            $table->unsignedBigInteger('id_age')->comment('Id edad');
            $table->foreign('id_age')->references('id')->on('ages');

            $table->unsignedBigInteger('id_purpose')->comment('Id propósito');
            $table->foreign('id_purpose')->references('id')->on('purposes');

            $table->unsignedBigInteger('id_outlet')->comment('Id de expendio');
            $table->foreign('id_outlet')->references('id')->on('outlets');

            $table->unsignedBigInteger('id_city')->comment('Ciudad de procedencia');
            $table->foreign('id_city')->references('id')->on('cities');

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
        Schema::dropIfExists('incomes');
    }
};
