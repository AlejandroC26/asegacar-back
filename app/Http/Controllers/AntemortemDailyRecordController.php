<?php

namespace App\Http\Controllers;

use App\Exports\AntemortemDailyRecordExport;
use App\Http\Requests\AntemortemDailyRecordRequestFormatRequest;
use App\Http\Requests\UpdateAntemortemDailyRecordRequest;
use App\Http\Resources\AntemortemDailyRecordPendingResource;
use App\Http\Resources\AntemortemDailyRecordResource;
use App\Models\DailyPayroll;
use App\Models\IncomeForm;
use App\Traits\ApiResponse;
use Maatwebsite\Excel\Facades\Excel;


class AntemortemDailyRecordController extends Controller
{
    use ApiResponse;

    public function index()
    {
        try {
            $records = IncomeForm::whereDoesntHave('dailyPayroll')->get();
            return $this->successResponse(AntemortemDailyRecordPendingResource::collection($records));
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    public function show($id)
    {
        try {
            $record = IncomeForm::find($id);
            return $this->successResponse(AntemortemDailyRecordPendingResource::make($record), 'Listado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    public function update(UpdateAntemortemDailyRecordRequest $request, $id)
    {
        try {
            $dailyPayroll = DailyPayroll::create(array_merge($request->validated(), [ 'id_income_form' => $id ]));
            return $this->successResponse($dailyPayroll, 'Actualizado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    public function destroy($id)
    {
        try {
            $record = DailyPayroll::find($id);
            $record->delete();
            return $this->successResponse($record, 'Eliminado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }

    public function download(AntemortemDailyRecordRequestFormatRequest $request)
    {
        try { 
            $arrayGuides = [];
                
            $guides = DailyPayroll::select('daily_payrolls.*', 'id_guide')
            ->leftJoin('income_forms', 'income_forms.id', 'id_income_form')
            ->join('daily_payroll_master', 'daily_payroll_master.id', 'income_forms.id_dp_master')
            ->where('sacrifice_date', $request->sacrifice_date)->groupBy('id_guide')->get();
            
            $arrayGuides = $guides->pluck('id_guide')->unique();
            $dailyrecords = DailyPayroll::select('daily_payrolls.*', 'id_guide')
                ->leftJoin('income_forms', 'income_forms.id', 'id_income_form')
                ->join('daily_payroll_master', 'daily_payroll_master.id', 'income_forms.id_dp_master')
                ->where('sacrifice_date', $request->sacrifice_date)
                ->orWhere(function ($query) use ($arrayGuides) {
                    $query->whereIn('id_guide', $arrayGuides)
                        ->whereNull('sacrifice_date');
                })->get();
            
            $records = AntemortemDailyRecordResource::collection($dailyrecords);
            $records = json_decode($records->toJson(), true);

            $aData = [];
            $nTotal = count($records);
            
            $outlets = [];

            foreach ($records as $record) {
                if(array_key_exists($record['outlet'], $outlets)) {
                    $outlets[$record['outlet']] += 1;
                } else {
                    $outlets[$record['outlet']] = 1;
                }
                $tmpArray = [
                    "code" => $record['code'],
                    "tm" => $record['id_gender'] === 1 ? 1 : 0,
                    "tf" => $record['id_gender'] === 2 ? 1 : 0,
                    "age" => $record['age'],
                    "outlet" => $record['outlet'].'-'.$outlets[$record['outlet']],
                    "st" => $record['id_gender'] === 1 ? 1 : 0,
                    "sf" => $record['id_gender'] === 2 ? 1 : 0,
                ];
                if(!array_key_exists($record['id_guide'], $aData)) {
                    $aData[$record['id_guide']] = array_merge($tmpArray, [
                        "id_guide" => $record['id_guide'],
                        "guide" => $record['guide'],
                        "date_entry" => $record['date_entry'],
                        "time_entry" => $record['time_entry'],
                        //
                        "records" => []
                    ]);
                } else {
                    $aData[$record['id_guide']]["records"][] = $tmpArray; 
                }
            }

            $user = $dailyrecords[0]->incomeForm?->master?->assistant_veterinarian;
            $general['date'] = $request->sacrifice_date;
            $general['responsable'] = $user?->fullname;
            $general['signature'] = $user?->signature;

            return Excel::download(new AntemortemDailyRecordExport(array_values($aData), $nTotal, $general), 'invoices.xlsx');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be shoed', $exception->getMessage(), 422);
        }
    }

    public function sltAntemoremOutlet($relation)
    {
        try {
            $outlets = DailyPayroll::whereNotNull('id_outlet')->whereDoesntHave($relation)->groupBy('id_outlet')->get();
            return response()->json(AntemortemDailyRecordResource::toOutletSelect($outlets));
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }

    public function sltAntemoremAnimals($relation, $id)
    {
        try {
            $animals = DailyPayroll::select('daily_payrolls.id', 'code as name')
                ->leftJoin('income_forms', 'income_forms.id', 'daily_payrolls.id_income_form')
                ->whereDoesntHave($relation)->where('id_outlet', $id)->get();
            return response()->json($animals);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }
}
