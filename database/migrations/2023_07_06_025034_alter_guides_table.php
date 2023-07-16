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
        Schema::table('guides', function (Blueprint $table) {
            $table->integer('no_animals')->after('code')->nullable();
            $table->integer('consecutive')->after('no_animals')->nullable();
            $table->unsignedBigInteger('id_specie')->comment('Id de especie');
            $table->foreign('id_specie')->references('id')->on('species');
            $table->text('file_attached')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
