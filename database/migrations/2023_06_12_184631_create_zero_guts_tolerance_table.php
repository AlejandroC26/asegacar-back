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
        Schema::create('zero_guts_tolerance', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('id_master')->comment('Id de matriz');
            $table->foreign('id_master')->references('id')->on('master_table');
            
            $table->unsignedBigInteger('id_antemortem_daily_record')->comment('Id de animal');
            $table->foreign('id_antemortem_daily_record')->references('id')->on('antemortem_daily_records');
            
            $table->string('organ')->nullable();
            $table->string('fecal_matter')->nullable();
            $table->string('resume')->nullable();
            $table->string('hide')->nullable();
            $table->string('hair')->nullable();
            $table->string('hem')->nullable();
            $table->string('abscess')->nullable();
            $table->string('parasite')->nullable();
            $table->string('others')->nullable();
            $table->string('correction')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('observations')->nullable();

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
        Schema::dropIfExists('zero_guts_tolerance');
    }
};
