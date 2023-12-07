<?php

namespace App\Http\Controllers;

use App\Exports\AntemortemDailyRecordExport;
use App\Http\Requests\AntemortemDailyRecordRequestFormatRequest;
use App\Http\Requests\StoreAntemortemDailyRecordRequest;
use App\Http\Requests\UpdateAntemortemDailyRecordRequest;
use App\Http\Resources\AntemortemDailyRecordResource;
use App\Models\DailyPayroll;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;

class AntemortemDailyRecordController extends Controller
{
    use ApiResponse;

    public function index()
    {
        try {
            $records = DailyPayroll::select('daily_payrolls.*', 'id_guide')
            ->join('daily_payroll_master', 'daily_payroll_master.id', 'daily_payrolls.id_dp_master')
            ->whereNull('sacrifice_date')->get();

            return $this->successResponse(AntemortemDailyRecordResource::collection($records));
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    public function pending()
    {
        try {
            $records = DailyPayroll::select('daily_payrolls.*', 'id_guide')
            ->join('daily_payroll_master', 'daily_payroll_master.id', 'daily_payrolls.id_dp_master')
            ->whereNull('sacrifice_date')->get();

            return response()->json(AntemortemDailyRecordResource::collection($records));
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    public function store(StoreAntemortemDailyRecordRequest $request)
    {
        try {
            
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be registered', $exception->getMessage(), 422);
        }
    }

    public function show($id)
    {
        try {
            $record = DailyPayroll::select('daily_payrolls.*', 'id_guide')
                ->join('daily_payroll_master', 'daily_payroll_master.id', 'daily_payrolls.id_dp_master')
                ->where('daily_payrolls.id', $id)
                ->first();
            return $this->successResponse(AntemortemDailyRecordResource::make($record), 'Listado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    public function update(UpdateAntemortemDailyRecordRequest $request, $id)
    {
        try {
            $record = DailyPayroll::findOrFail($id);

            $oUniqueCode = DailyPayroll::whereHas('master', function(Builder $query) use ($record){
                $query->whereYear('date', $record->master->date);
                $query->whereMonth('date', Carbon::createFromFormat('Y-m-d', $record->master->date)->month);
            })->where(['code' => $record->code])->whereNotNull('id_outlet')->first();
            
            if($oUniqueCode) {
                return $this->errorResponse('The record could not be updated', ['The code must be unique in the spreadsheet.'], 409);
            }
            
            $record->update($request->validated());
            return $this->successResponse($record, 'Actualizado exitosamente');
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
            ->join('daily_payroll_master', 'daily_payroll_master.id', 'daily_payrolls.id_dp_master')
            ->where('sacrifice_date', $request->sacrifice_date)->groupBy('id_guide')->get();

            foreach ($guides as $guide) {
				$arrayGuides[] = $guide->id;
			}
    
            $dailyrecords = DailyPayroll::select('daily_payrolls.*', 'id_guide')
                ->join('daily_payroll_master', 'daily_payroll_master.id', 'daily_payrolls.id_dp_master')
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

            $general['date'] = $request->sacrifice_date;
            $general['responsable'] = $dailyrecords[0]?->master?->responsable?->fullname;

            return Excel::download(new AntemortemDailyRecordExport(
                array_values($aData), 
                $nTotal, 
                $general
            ), 'invoices.xlsx');
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
            $animals = DailyPayroll::select('id', 'code as name')->whereDoesntHave($relation)->where('id_outlet', $id)->get();
            return response()->json($animals);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }
}
