<?php

namespace App\Console\Commands;

use App\Models\DailyMatrix;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateDailyMatrixView extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:matrix-view';

    /**
     * The console command description.
     *
     * @var string
     */

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::statement("DROP VIEW IF EXISTS daily_matrix_view");
        DB::statement(DailyMatrix::onGetMakeViewSQL());
    }
}
