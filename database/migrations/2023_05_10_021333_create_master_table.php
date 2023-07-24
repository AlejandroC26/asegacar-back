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
        Schema::create('master_table', function (Blueprint $table) {
            $table->id();

            $table->date('date');

            $table->unsignedBigInteger('id_responsable')->nullable();
            $table->foreign('id_responsable')->references('id')->on('persons');

            $table->unsignedBigInteger('id_verified_by')->nullable();
            $table->foreign('id_verified_by')->references('id')->on('persons');

            $table->unsignedBigInteger('id_supervised_by')->nullable();
            $table->foreign('id_supervised_by')->references('id')->on('persons');

            $table->unsignedBigInteger('id_elaborated_by')->nullable();
            $table->foreign('id_elaborated_by')->references('id')->on('persons');

            $table->unsignedBigInteger('id_master_type')->comment('Id tipo de maestra');
            $table->foreign('id_master_type')->references('id')->on('master_types');

            $table->boolean('state')->default(1);
            
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
        Schema::dropIfExists('master_table');
    }
};
