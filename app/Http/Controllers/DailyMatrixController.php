<?php

namespace App\Http\Controllers;

use App\Exports\DailyMatrixExport;
use App\Helpers\FormatDateHelper;
use App\Models\DailyPayroll;
use App\Models\PostmortemInspections;
use App\Models\SeizureComparison;
use Carbon\Carbon;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class DailyMatrixController extends Controller
{
    use ApiResponse;
    
    public function index()
    {
        try {
            $dailyMatrix = DB::table('daily_matrix_view')->get();
            return $dailyMatrix;
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    public function download(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'benefit_date' => 'required|max:255',
            ]);
            if($validator->fails()) 
                return $this->errorResponse('Field validation failed', $validator->errors(), 400);
    
            $dailyMatrix = DB::table('daily_matrix_view')
                ->where('sacrifice_date', $request->benefit_date)
                ->get();

            $dailyMatrix = $dailyMatrix->map(function($record) {
                $matchedFields  = SeizureComparison::onGetMatchesWithData(PostmortemInspections::onGetFieldsToMatch($record->id));
                $matchedCauses  = PostmortemInspections::onGetFieldsCause($record->id, $matchedFields);
                $record->seizures = collect($matchedCauses)->pluck('field')->toArray();
                return $record;
            });

            if(!count($dailyMatrix)) {
                return $this->errorResponse('Not found', ['No se encontraron registros en esta fecha'], 404);
            }

            $user = DailyPayroll::find($dailyMatrix[0]?->id)?->incomeForm->master->administrative_assistant;

            $config['responsable'] = $user?->fullname;
            $config['signature'] = $user?->signature;

            $date = Carbon::parse($request->benefit_date);
            $text_date = FormatDateHelper::onNumberToDay($date->dayOfWeek);
            $text_month = FormatDateHelper::onNumberToMonth(intval($date->format('m')));
            $benefit_date = strtoupper($text_date).' '.$date->format('d').' DE '.strtoupper($text_month).' DEL '.$date->format('Y');
            return Excel::download(new DailyMatrixExport($dailyMatrix, $benefit_date, $config), 'invoices.xlsx');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }
}
