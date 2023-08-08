<?php

namespace App\Http\Controllers;

use App\Exports\DailyPayrollExport;
use App\Http\Requests\StoreDailyPayrollRequest;
use App\Http\Resources\DailyPayrollResource;
use App\Models\DailyPayroll;
use App\Models\DailyPayrollMaster;
use App\Models\Guide;
use App\Models\MasterType;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DailyPayrollController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $aMasterTable = DailyPayrollMaster::all();
            return response()->json(DailyPayrollResource::collection($aMasterTable));
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDailyPayrollRequest $request)
    {
        try {       
            DB::beginTransaction();

            $oMasterTable = DailyPayrollMaster::create(
                $request->except(['entries'])
            );

            $oGuide = Guide::find($request->id_guide);

            if($oGuide->no_animals !== count($request->validated()['entries'])) {
                return $this->errorResponse('The record could not be saved', ['You must record the number of animals assigned to the guide.'], 409);
            }

            foreach ($request->validated()['entries'] as $entrie) {
                $oUniqueCode = DailyPayroll::where([
                    'id_dp_master' => $oMasterTable->id,
                    'code' => $entrie['code'],
                ])->first();
                if($oUniqueCode) {
                    return $this->errorResponse('The record could not be saved', ['The code must be unique in the spreadsheet.'], 409);
                }
                DailyPayroll::create(array_merge($entrie, ['id_dp_master' => $oMasterTable->id,]));
            }

            DB::commit();

            return $this->successResponse([], 'Registro realizado exitosamente', 200);
        } catch (\Throwable $exception) {
            DB::rollBack();
            return $this->errorResponse('The record could not be registered', $exception->getMessage(), 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $aMasterTable = DailyPayrollMaster::find($id);
            $aMasterTable['entries'] = $aMasterTable->dailyPayrolls;
            return $this->successResponse($aMasterTable, 'Listado exitosamente', 200);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreDailyPayrollRequest $request, $id)
    {
        try {

            $oMasterTable = DailyPayrollMaster::find($id);
            
            if($oMasterTable?->guide->no_animals !== count($request->validated()['entries'])) {
                return $this->errorResponse('The record could not be saved', ['You must record the number of animals assigned to the guide.'], 409);
            }

            $oMasterTable->update(
                $request->except(['entries'])
            );
            
            DailyPayroll::where('id_dp_master', $id)->delete();
            foreach ($request->validated()['entries'] as $entrie) {
                $oUniqueCode = DailyPayroll::where([
                    'id_dp_master' => $oMasterTable->id,
                    'code' => $entrie['code'],
                ])->first();
                if($oUniqueCode) {
                    return $this->errorResponse('The record could not be updated', ['The code must be unique in the spreadsheet.'], 409);
                }
                DailyPayroll::create(array_merge($entrie, ['id_dp_master' => $oMasterTable->id]));
            }

            return $this->successResponse($oMasterTable, 'Actualizado exitosamente', 200);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DailyPayroll::where('id_dp_master', $id)->delete();
            DailyPayrollMaster::where('id', $id)->delete();

            return $this->successResponse([], 'Eliminado exitosamente', 200);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }

    public function sltDailyPayrolls()
    {
        try {
            $dailyPayrolls = DailyPayrollMaster::with('responsable')->get();
            $dailyPayrolls = DailyPayrollResource::toSelect($dailyPayrolls);
            return response()->json($dailyPayrolls);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    public function download(Request $request)
    {
        try { 
            $total_males = 0;
            $total_females = 0;

            $dailyPayroll = DailyPayroll::with('outlet', 'master.responsable')->select(
                    'daily_payrolls.id', 
                    'id_dp_master', 
                    'id_outlet',
                    DB::raw("GROUP_CONCAT(distinct(colors.name) SEPARATOR ', ') as colors"),
                    DB::raw("GROUP_CONCAT(distinct(genders.name) SEPARATOR ', ') as genders"),
                    DB::raw("SUM(CASE WHEN id_gender = 1 THEN 1 END) AS total_males"),
                    DB::raw("SUM(CASE WHEN id_gender = 2 THEN 1 END) AS total_females"),
                    DB::raw("GROUP_CONCAT(special_order SEPARATOR ', ')	AS special_order"),
                    'daily_payrolls.created_at'
                )
                ->leftJoin('colors', 'colors.id', '=', 'daily_payrolls.id_color')
                ->leftJoin('genders', 'genders.id', '=', 'daily_payrolls.id_gender')
                ->where('id_dp_master', $request->id_master)
                ->groupBy('id_outlet')
                ->get();

            $total_males = 0;
            $total_females = 0;
            foreach ($dailyPayroll as $element) {
                $total_males += $element->total_females;
                $total_females += $element->total_females;
            }
            $general = $dailyPayroll[0] ? $dailyPayroll[0]->master : [];
            
            return Excel::download(new DailyPayrollExport($dailyPayroll, $total_males, $total_females, $general), 'invoices.xlsx');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be shoed', $exception->getMessage(), 422);
        }
    }
}
