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
        Schema::create('charge_categories', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_charge')->comment('Id del cargo');
            $table->foreign('id_charge')->references('id')->on('charges');

            $table->unsignedBigInteger('id_app_route_categorie');
            $table->foreign('id_app_route_categorie')->references('id')->on('app_route_categories');

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
        Schema::dropIfExists('charge_categories');
    }
};
