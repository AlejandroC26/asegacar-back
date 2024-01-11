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
        Schema::table('dispatch_guides', function (Blueprint $table) {
            $table->string('white_viscera')->nullable()->after('id_vehicle');
            $table->string('red_viscera')->nullable()->after('id_vehicle');
            $table->string('heads')->nullable()->after('id_vehicle');
            $table->string('legs')->nullable()->after('id_vehicle');
            $table->string('others')->nullable()->after('id_vehicle');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dispatch_guides', function (Blueprint $table) {
            //
        });
    }
};
