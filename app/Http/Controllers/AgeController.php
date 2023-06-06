<?php

namespace App\Http\Controllers;

use App\Exports\AgeBobinsExport;
use App\Helpers\FormatDateHelper;
use App\Http\Resources\AgeResource;
use App\Models\Age;
use App\Models\AntemortemDailyRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class AgeController extends Controller
{
    use ApiResponse;

    public function index()
    {
        try {
            $ages = Age::all();
            return response()->json(AgeResource::collection($ages));
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    public function store(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'description' => 'required|max:255',
            ]);
            
            if($validator->fails()) 
                return response()->json(['message' => 'Field validation failed: '.$validator->errors()->toJson()],400);
        
            $age = Age::create([
                "description" => $request->description,
            ]);

            return $this->successResponse($age, 'Registro realizado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be registered', $exception->getMessage(), 422);
        }
    }

    public function show ($id) {
        try {
            $age = Age::find($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Listado exitosamente',
                'data' => $age
            ]);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    public function update(Request $request, $id) {
        try {
            $age = Age::find($id);
            
            if(!$age)
                return response()->json(['message' => 'Does not found']);
    
            $validator = Validator::make($request->all(), [
                'description' => 'required|max:255',
            ]);
    
            if($validator->fails()) 
                return response()->json(['message' => 'Field validation failed: '.$validator->errors()->toJson()],400);
            
            $age->update([
                'description' => $request->description
            ]);
            
            return $this->successResponse($age, 'Actualizado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    public function sltAges() {
        try {
            $ages = Age::select('id', 'description')->get();
            return response()->json($ages);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }

    public function destroy($id) {
        try {
            $age = Age::find($id);
            $age->delete();
            return $this->successResponse($age, 'Eliminado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }

    public function download(Request $request){
        try {

            $date = Carbon::parse($request->date);

            $first_date = date('Y-m-01', strtotime($request->date));
            $last_date = date('Y-m-t', strtotime($request->date));

            $oDate["month"] = strtoupper(FormatDateHelper::onNumberToMonth(intval($date->format('m'))));
            $oDate["year"]  = $date->format('Y');

            $aRecords = AntemortemDailyRecord::whereBetween('sacrifice_date', [$first_date, $last_date])->get();
            $aResults = [];
            $oTotals = [
                "males" => [
                    "1-2" => 0,
                    "2-3" => 0,
                    "> 3" => 0,
                    "total" => 0
                ],
                "females" => [
                    "1-2" => 0,
                    "2-3" => 0,
                    "> 3" => 0,
                    "total" => 0
                ],
                "total" => 0,
                "purposes" => [
                    "meat" => 0,
                    "milk" => 0,
                    "double" => 0,
                    "total" => 0,
                ],
            ];

            foreach ($aRecords as $oRecord) {
                $oTotals["males"]["1-2"] += ($oRecord->id_gender == 1 && $oRecord->id_age === 1) ? 1 : 0;
                $oTotals["males"]["2-3"] += ($oRecord->id_gender == 1 && $oRecord->id_age === 2) ? 1 : 0;
                $oTotals["males"]["> 3"] += ($oRecord->id_gender == 1 && $oRecord->id_age === 3) ? 1 : 0;
                $oTotals["males"]["total"] += ($oRecord->id_gender == 1) ? 1 : 0;

                $oTotals["females"]["1-2"] += ($oRecord->id_gender == 2 && $oRecord->id_age === 1) ? 1 : 0;
                $oTotals["females"]["2-3"] += ($oRecord->id_gender == 2 && $oRecord->id_age === 2) ? 1 : 0;
                $oTotals["females"]["> 3"] += ($oRecord->id_gender == 2 && $oRecord->id_age === 3) ? 1 : 0;
                $oTotals["females"]["total"] += ($oRecord->id_gender == 2) ? 1 : 0;
                $oTotals["total"] += 1;

                $oTotals["purposes"]["meat"] += ($oRecord->id_purpose == 1) ? 1 : 0;
                $oTotals["purposes"]["milk"] += ($oRecord->id_purpose == 2) ? 1 : 0;
                $oTotals["purposes"]["double"] += ($oRecord->id_purpose == 3) ? 1 : 0;
                $oTotals["purposes"]["total"] += ($oRecord->id_purpose >= 1 && $oRecord->id_purpose <= 3) ? 1 : 0;

                if(!array_key_exists($oRecord->sacrifice_date, $aResults)) {
                    $aResults[$oRecord->sacrifice_date] = [
                        "date" => $oRecord->sacrifice_date,
                        "males" => [
                            "1-2" => ($oRecord->id_gender == 1 && $oRecord->id_age === 1) ? 1 : 0,
                            "2-3" => ($oRecord->id_gender == 1 && $oRecord->id_age === 2) ? 1 : 0,
                            "> 3" => ($oRecord->id_gender == 1 && $oRecord->id_age === 3) ? 1 : 0,
                            "total" => ($oRecord->id_gender == 1) ? 1 : 0
                        ],
                        "females" => [
                            "1-2" => ($oRecord->id_gender == 2 && $oRecord->id_age === 1) ? 1 : 0,
                            "2-3" => ($oRecord->id_gender == 2 && $oRecord->id_age === 2) ? 1 : 0,
                            "> 3" => ($oRecord->id_gender == 2 && $oRecord->id_age === 3) ? 1 : 0,
                            "total" => ($oRecord->id_gender == 2) ? 1 : 0
                        ],
                        "total" => 1,
                        "purposes" => [
                            "meat" => ($oRecord->id_purpose == 1) ? 1 : 0,
                            "milk" => ($oRecord->id_purpose == 2) ? 1 : 0,
                            "double" => ($oRecord->id_purpose == 3) ? 1 : 0,
                            "total" => ($oRecord->id_purpose >= 1 && $oRecord->id_purpose <= 3) ? 1 : 0,
                        ],
                        "guides" => [ $oRecord->id_guide ]
                    ];
                } else {
                    $aResults[$oRecord->sacrifice_date]["males"]["1-2"] += ($oRecord->id_gender == 1 && $oRecord->id_age === 1) ? 1 : 0;
                    $aResults[$oRecord->sacrifice_date]["males"]["2-3"] += ($oRecord->id_gender == 1 && $oRecord->id_age === 2) ? 1 : 0;
                    $aResults[$oRecord->sacrifice_date]["males"]["> 3"] += ($oRecord->id_gender == 1 && $oRecord->id_age === 3) ? 1 : 0;
                    $aResults[$oRecord->sacrifice_date]["males"]["total"] += ($oRecord->id_gender == 1) ? 1 : 0;

                    $aResults[$oRecord->sacrifice_date]["females"]["1-2"] += ($oRecord->id_gender == 2 && $oRecord->id_age === 1) ? 1 : 0;
                    $aResults[$oRecord->sacrifice_date]["females"]["2-3"] += ($oRecord->id_gender == 2 && $oRecord->id_age === 2) ? 1 : 0;
                    $aResults[$oRecord->sacrifice_date]["females"]["> 3"] += ($oRecord->id_gender == 2 && $oRecord->id_age === 3) ? 1 : 0;
                    $aResults[$oRecord->sacrifice_date]["females"]["total"] += ($oRecord->id_gender == 2) ? 1 : 0;

                    $aResults[$oRecord->sacrifice_date]["total"] += 1;

                    $aResults[$oRecord->sacrifice_date]["purposes"]["meat"] += ($oRecord->id_purpose == 1) ? 1 : 0;
                    $aResults[$oRecord->sacrifice_date]["purposes"]["milk"] += ($oRecord->id_purpose == 2) ? 1 : 0;
                    $aResults[$oRecord->sacrifice_date]["purposes"]["double"] += ($oRecord->id_purpose == 3) ? 1 : 0;
                    $aResults[$oRecord->sacrifice_date]["purposes"]["total"] += ($oRecord->id_purpose >= 1 && $oRecord->id_purpose <= 3) ? 1 : 0;

                    if(!in_array($oRecord->id_guide, $aResults[$oRecord->sacrifice_date]["guides"], true)) {
                        $aResults[$oRecord->sacrifice_date]["guides"][] = $oRecord->id_guide;
                    }
                }
            }
            return Excel::download(new AgeBobinsExport(array_values($aResults), $oTotals, $oDate), 'invoices.xlsx');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be downloaded', $exception->getMessage(), 422);
        }
    }
}
