<?php

namespace App\Http\Controllers;

use App\Exports\DailyPayrollExport;
use App\Http\Requests\StoreDailyPayrollRequest;
use App\Http\Requests\UpdateDailyPayrollRequest;
use App\Http\Resources\DailyPayrollResource;
use App\Http\Resources\ShowDailyPayrollResource;
use App\Models\DailyPayroll;
use App\Models\DailyPayrollMaster;
use App\Models\IncomeForm;
use App\Models\ProductType;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
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
    public function index()
    {
        try {
            $aMasterTable = DailyPayrollMaster::has('incomeForms')->get();
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

            foreach ($request->validated()['entries'] as $entrie) {
                $oIncomeForm = IncomeForm::where([
                    'id_dp_master' => $request->id_dp_master,
                    'code' => $entrie['code']
                ])->first();
                DailyPayroll::create(array_merge($entrie, ['id_income_form' => $oIncomeForm->id]));
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
            return $this->successResponse(ShowDailyPayrollResource::make($aMasterTable), 'Listado exitosamente', 200);
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
    public function update(UpdateDailyPayrollRequest $request, $id)
    {
        try {
            $oMasterTable = DailyPayrollMaster::find($id);
            
            $oMasterTable->update($request->except(['entries']));

            foreach ($request->validated(['entries']) as $entrie) {
                $oIncomeForm = IncomeForm::where(['code' => $entrie['code'], 'id_dp_master' => $id])->first();
                DailyPayroll::where('id_income_form', $oIncomeForm->id)->update(collect($entrie)->except(['code'])->toArray());
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
    
    public function sltProductTypes()
    {
        try {
            $productTypes = ProductType::select('id', 'name')->get();
            return response()->json($productTypes);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    public function sltPayrrollsGuide($relation, $id)
    {
        try {
            $dailyPayrolls = DailyPayroll::whereDoesntHave($relation)->whereHas('incomeForm', function(Builder $query) use ($id) {
                $query->where('id_guide', $id);
            })->get();

            $dailyPayrolls = $dailyPayrolls->map(function($dailyPayroll) {
                return [
                    'id' => $dailyPayroll->id,
                    'name' => $dailyPayroll->incomeForm->code
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

            $dailyPayroll = DailyPayroll::with('outlet', 'incomeForm.master')->select(
                'daily_payrolls.id', 
                'id_dp_master', 
                'id_outlet',
                'number',
                'id_income_form',
                'colors.name as colors',
                'genders.name as genders',
                "income_forms.code as codes",
                "guides.code as guides",
                DB::raw("CASE WHEN id_gender = 1 THEN 1 END AS total_males"),
                DB::raw("CASE WHEN id_gender = 2 THEN 1 END AS total_females"),
                "daily_payrolls.special_order AS special_order",
                'daily_payrolls.created_at'
            )
            ->leftJoin('outlets', 'outlets.id', 'id_outlet')
            ->leftJoin('income_forms', 'income_forms.id', 'id_income_form')
            ->leftJoin('guides', 'guides.id', 'id_guide')
            ->leftJoin('colors', 'colors.id', '=', 'income_forms.id_color')
            ->leftJoin('genders', 'genders.id', '=', 'income_forms.id_gender')
            ->leftJoin('daily_payroll_master', 'daily_payroll_master.id', 'id_dp_master')
            ->where('daily_payrolls.sacrifice_date', $request->date)
            ->whereNotNull('id_outlet')
            ->orderBy(DB::raw('CAST(outlets.code as SIGNED)'), 'ASC')
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
            
            $user = $dailyPayroll[0]?->incomeForm->master?->administrative_assistant;

            $general['date'] = $request->date;
            $general['responsable'] = $user->fullname;
            $general['signature'] = $user->signature;
            
            return Excel::download(new DailyPayrollExport($dailyPayroll, $total_males, $total_females, $general), 'invoices.xlsx');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }
}
