<?php

namespace App\Http\Controllers;

use App\Exports\DailyPayrollExport;
use App\Http\Requests\StoreDailyPayrollRequest;
use App\Http\Resources\DailyPayrollResource;
use App\Models\DailyPayroll;
use App\Models\DailyPayrollMaster;
use App\Models\GeneralParam;
use App\Models\Guide;
use App\Models\MasterType;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Builder;

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
            return $this->successResponse(DailyPayrollResource::collection($aMasterTable));
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

            $responsable_id = GeneralParam::onGetResponsable();
            if(!$responsable_id) {
                return $this->errorResponse('The record could not be saved', ['Configura un responsable en la tabla de firmas para continuar'], 409);
            }

            $oMasterTable = DailyPayrollMaster::create(array_merge($request->except(['entries']), [
                'id_responsable' => $responsable_id
            ]));

            $oGuide = Guide::find($request->id_guide);

            if($oGuide->no_animals !== count($request->validated()['entries'])) {
                return $this->errorResponse('The record could not be saved', ['Registra el número de animales asignados en la guía'], 409);
            }

            foreach ($request->validated()['entries'] as $entrie) {
                $oUniqueCode = DailyPayroll::whereHas('master', function(Builder $query) use ($request){
                    $query->whereYear('date', $request->date);
                    $query->whereMonth('date', Carbon::createFromFormat('Y-m-d', $request->date)->month);
                })->where(['code' => $entrie['code']])->first();
                if($oUniqueCode) {
                    return $this->errorResponse('The record could not be saved', ['El código debe ser único por día'], 409);
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
                return $this->errorResponse('The record could not be saved', ['Registra el número de animales asignados en la guía'], 409);
            }

            $oMasterTable->update(
                $request->except(['entries'])
            );

            $entries = collect($request->entries);
            $aCodes = $entries->pluck('code');

            $oldRecords = DailyPayroll::where('id_dp_master', $oMasterTable->id)->whereNotIn('code',$aCodes)->get();

            $oldRecordsIndex = 0;
            foreach ($request->validated()['entries'] as $entrie) {
                $oUniqueCode = DailyPayroll::whereHas('master', function(Builder $query) use ($request){
                    $query->whereYear('date', $request->date);
                    $query->whereMonth('date', Carbon::createFromFormat('Y-m-d', $request->date)->month);
                })->where(['code' => $entrie['code']])->where('id_dp_master', '!=', $oMasterTable->id)->first();
                if($oUniqueCode) {
                    return $this->errorResponse('The record could not be updated', ['El código debe ser único por día'], 409);
                }

                $existsDailyPayroll = DailyPayroll::where(['code' => $entrie['code'], 'id_dp_master' => $oMasterTable->id])->first();
                if($existsDailyPayroll) {
                    $existsDailyPayroll->update($entrie);
                } else {
                    if(array_key_exists($oldRecordsIndex, $oldRecords->toArray())) {
                        $oldRecords[$oldRecordsIndex]->update($entrie);
                        $oldRecordsIndex += 1;
                    } else {
                        DailyPayroll::create(array_merge($entrie, ['id_dp_master' => $oMasterTable->id]));
                    }
                }
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

    public function sltPayrrollsGuide($id)
    {
        try {
            $dailyPayrolls = DailyPayroll::whereHas('master', function(Builder $query) use ($id) {
                $query->where('id_guide', $id);
            })->get();

            $dailyPayrolls = $dailyPayrolls->map(function($dailyPayroll) {
                return [
                    'id' => $dailyPayroll['id'],
                    'name' => $dailyPayroll['code']
                ];
            });
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
                ->leftJoin('daily_payroll_master', 'daily_payroll_master.id', 'id_dp_master')
                ->where('daily_payroll_master.date', $request->date)
                ->whereNotNull('id_outlet')
                ->groupBy('id_outlet')
                ->get();

            if(!count($dailyPayroll)) {
                return $this->errorResponse('Not found', ['No se encontraron registros en esta fecha'], 404);
            }


            $total_males = 0;
            $total_females = 0;
            foreach ($dailyPayroll as $element) {
                $total_males += intval($element->total_males);
                $total_females += intval($element->total_females);
            }
            
            $general['date'] = $request->date;
            $general['responsable'] = $dailyPayroll[0]?->master?->responsable?->fullname;

            return Excel::download(new DailyPayrollExport($dailyPayroll, $total_males, $total_females, $general), 'invoices.xlsx');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be shoed', $exception->getMessage(), 422);
        }
    }
}
