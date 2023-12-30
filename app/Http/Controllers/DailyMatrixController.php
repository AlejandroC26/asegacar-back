<?php

namespace App\Http\Controllers;

use App\Exports\DailyMatrixExport;
use App\Helpers\FormatDateHelper;
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

            if(!count($dailyMatrix)) {
                return $this->errorResponse('Not found', ['No se encontraron registros en esta fecha'], 404);
            }

            $date = Carbon::parse($request->benefit_date);
            $text_date = FormatDateHelper::onNumberToDay($date->dayOfWeek);
            $text_month = FormatDateHelper::onNumberToMonth(intval($date->format('m')));
            $benefit_date = strtoupper($text_date).' '.$date->format('d').' DE '.strtoupper($text_month).' DEL '.$date->format('Y');
            return Excel::download(new DailyMatrixExport($dailyMatrix, $benefit_date), 'invoices.xlsx');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }
}
