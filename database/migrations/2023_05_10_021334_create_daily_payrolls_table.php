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
        Schema::create('daily_payrolls', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_outlet')->comment('Id de expendio');
            $table->foreign('id_outlet')->references('id')->on('outlets');

            $table->integer('total_males');
            $table->integer('total_females');

            $table->longText('special_order')->nullable()->comment('Orden especial');
            $table->date('benefit_date');
            
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
        Schema::dropIfExists('daily_payrolls');
    }
};
