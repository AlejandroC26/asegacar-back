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
        Schema::create('guides', function (Blueprint $table) {
            $table->id();
            $table->text('code');
            $table->integer('no_animals')->nullable();
            $table->date('date_entry');
            $table->time('time_entry');
            $table->string('establishment_name')->comment('Nombre establecimiento');
            $table->string('file_attached')->nullable();
            $table->string('consecutive');
            $table->boolean('state')->default(1);

            $table->unsignedBigInteger('id_owner')->comment('Id de la persona propietaria');
            $table->foreign('id_owner')->references('id')->on('persons');

            $table->unsignedBigInteger('id_buyer')->comment('Id de la persona compradora');
            $table->foreign('id_buyer')->references('id')->on('persons');

            $table->unsignedBigInteger('id_source')->comment('Ciudad de procedencia');
            $table->foreign('id_source')->references('id')->on('cities');

            $table->unsignedBigInteger('id_destination')->comment('Ciudad de destino');
            $table->foreign('id_destination')->references('id')->on('cities');

            $table->unsignedBigInteger('id_specie')->comment('Especie');
            $table->foreign('id_specie')->references('id')->on('species');
            
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
        Schema::dropIfExists('guides');
    }
};
