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
        Schema::create('seizure_comparison', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_master')->comment('Id de matriz');
            $table->foreign('id_master')->references('id')->on('master_table');
            $table->unsignedBigInteger('id_antemortem_daily_record')->comment('Id de animal');
            $table->foreign('id_antemortem_daily_record')->references('id')->on('antemortem_daily_records');

            $table->string('small_ints')->nullable();
            $table->string('large_ints')->nullable();
            $table->string('liver')->nullable();
            $table->string('lung')->nullable();
            $table->string('udders')->nullable();
            $table->string('head')->nullable();
            $table->string('hands')->nullable();
            $table->string('legs')->nullable();
            $table->string('others')->nullable();
            $table->string('destocking')->nullable();

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
        Schema::dropIfExists('seizure_comparison');
    }
};
