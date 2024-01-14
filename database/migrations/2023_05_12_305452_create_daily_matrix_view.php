<?php

use App\Models\DailyMatrix;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement($this->dropView());
        DB::statement($this->createView());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    private function createView()
    {
        DB::statement(DailyMatrix::onGetMakeViewSQL());
    }
    
    /**
        * Reverse the migrations.
        *
        * @return void
        */
    private function dropView(): string
    {
        return <<<SQL
            DROP VIEW IF EXISTS daily_matrix_view;
        SQL;
    }
};
