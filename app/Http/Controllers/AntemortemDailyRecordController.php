<?php

namespace App\Http\Controllers;

use App\Exports\AntemortemDailyRecordExport;
use App\Http\Requests\AntemortemDailyRecordRequestFormatRequest;
use App\Http\Requests\StoreAntemortemDailyRecordRequest;
use App\Http\Resources\AntemortemDailyRecordResource;
use App\Models\AntemortemDailyRecord;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AntemortemDailyRecordController extends Controller
{
    use ApiResponse;

    public function index()
    {
        try {
            $records = AntemortemDailyRecord::all();
            return response()->json(AntemortemDailyRecordResource::collection($records));
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    public function pending()
    {
        try {
            $records = AntemortemDailyRecord::whereNull('sacrifice_date')->get();
            return response()->json(AntemortemDailyRecordResource::collection($records));
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    public function store(StoreAntemortemDailyRecordRequest $request)
    {
        try {
            $record = AntemortemDailyRecord::create($request->validated());
            return $this->successResponse($record, 'Registro realizado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be registered', $exception->getMessage(), 422);
        }
    }

    public function show($id)
    {
        try {
            $record = AntemortemDailyRecord::find($id);
            return $this->successResponse($record, 'Listado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    public function update(StoreAntemortemDailyRecordRequest $request, $id)
    {
        try {
            $record = AntemortemDailyRecord::findOrFail($id);        
            $record->update($request->validated());
            return $this->successResponse($record, 'Actualizado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    public function destroy($id)
    {
        try {
            $record = AntemortemDailyRecord::find($id);
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
            $guides = AntemortemDailyRecord::where('sacrifice_date', $request->sacrifice_date)->groupBy('id_guide')->get();
            foreach ($guides as $guide) {
				$arrayGuides[] = $guide->id;
			}

            $records = AntemortemDailyRecord::where('sacrifice_date', $request->sacrifice_date)
                ->orWhere(function ($query) use ($arrayGuides) {
                    $query->whereIn('id_guide', $arrayGuides)
                        ->whereNull('sacrifice_date');
                })
                ->get();
            
            $records = AntemortemDailyRecordResource::collection($records);
            $records = json_decode($records->toJson(), true);

            $aData = [];
            $nTotal = count($records);
            foreach ($records as $record) {
                $tmpArray = [
                    "code" => $record['code'],
                    "tm" => $record['id_gender'] === 1 ? 1 : 0,
                    "tf" => $record['id_gender'] === 2 ? 1 : 0,
                    "age" => $record['age'],
                    "outlet" => $record['outlet'],
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

            return Excel::download(new AntemortemDailyRecordExport(
                array_values($aData), 
                $nTotal, 
                $request->sacrifice_date
            ), 'invoices.xlsx');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be shoed', $exception->getMessage(), 422);
        }
    }
}
