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
        Schema::create('app_routes', function (Blueprint $table) {
            $table->id();

            $table->string('label');
            $table->string('route');

            $table->unsignedBigInteger('id_app_route_categories')->nullable()->comment('Id de categoría');
            $table->foreign('id_app_route_categories')->references('id')->on('app_route_categories');

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
        Schema::dropIfExists('app_routes');
    }
};
