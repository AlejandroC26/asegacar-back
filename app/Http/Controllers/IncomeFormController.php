<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIncomeFormRequest;
use App\Http\Resources\DailyPayrollResource;
use App\Http\Resources\IncomeFormResource;
use App\Http\Resources\ShowDailyPayrollResource;
use App\Http\Resources\ShowIncomeFormResource;
use App\Models\DailyPayrollMaster;
use App\Models\GeneralParam;
use App\Models\Guide;
use App\Models\IncomeForm;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class IncomeFormController extends Controller
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
            $aMasterTable = DailyPayrollMaster::whereHas('incomeForms')->get();
            return $this->successResponse(IncomeFormResource::collection($aMasterTable));
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
    public function store(StoreIncomeFormRequest $request)
    {
        try {       
            DB::beginTransaction();

            $id_administrative_assistant = GeneralParam::onGetGeneralParamByName('id_administrative_assistant');
            $id_quality_assistant = GeneralParam::onGetGeneralParamByName('id_quality_assistant');
            $id_operational_manager = GeneralParam::onGetGeneralParamByName('id_operational_manager');
            $id_assistant_veterinarian = GeneralParam::onGetGeneralParamByName('id_assistant_veterinarian');

            if(!$id_administrative_assistant) 
                return $this->errorResponse('The record could not be saved', ['Configura un auxiliar administrativo en la tabla de firmas para continuar'], 409);

            if(!$id_quality_assistant) 
                return $this->errorResponse('The record could not be saved', ['Configura un auxiliar de calidad en la tabla de firmas para continuar'], 409);

            if(!$id_operational_manager) 
                return $this->errorResponse('The record could not be saved', ['Configura un jefe operativo en la tabla de firmas para continuar'], 409);

            if(!$id_assistant_veterinarian) 
                return $this->errorResponse('The record could not be saved', ['Configura un médico veterinario auxiliar en la tabla de firmas para continuar'], 409);

            $oMasterTable = DailyPayrollMaster::create(array_merge($request->except(['entries']), [
                'id_administrative_assistant' => $id_administrative_assistant,
                'id_quality_assistant' => $id_quality_assistant,
                'id_operational_manager' => $id_operational_manager,
                'id_assistant_veterinarian' => $id_assistant_veterinarian,
            ]));

            $oGuide = Guide::find($request->id_guide);

            if($oGuide->no_animals !== count($request->validated()['entries'])) {
                return $this->errorResponse('The record could not be saved', ['Registra el número de animales asignados en la guía'], 409);
            }

            foreach ($request->validated()['entries'] as $entrie) {
                $oUniqueCode = IncomeForm::whereHas('master', function(Builder $query) use ($request){
                    $query->whereYear('date', $request->date);
                    $query->whereMonth('date', Carbon::createFromFormat('Y-m-d', $request->date)->month);
                })->where(['code' => $entrie['code']])->first();
                if($oUniqueCode) {
                    return $this->errorResponse('The record could not be saved', ['El código debe ser único por día'], 409);
                }
                IncomeForm::create(array_merge($entrie, [
                    'id_dp_master' => $oMasterTable->id,
                    'id_guide' => $request->id_guide
                ]));
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
     * @param  \App\Models\IncomeForm  $incomeForm
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $aMasterTable = DailyPayrollMaster::find($id);
            return $this->successResponse(ShowIncomeFormResource::make($aMasterTable), 'Listado exitosamente', 200);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\IncomeForm  $incomeForm
     * @return \Illuminate\Http\Response
     */
    public function update(StoreIncomeFormRequest $request, $id)
    {
        try {
            $oMasterTable = DailyPayrollMaster::find($id);
            if($oMasterTable?->incomeForms[0]->guide->no_animals !== count($request->validated()['entries'])) {
                return $this->errorResponse('The record could not be saved', ['Registra el número de animales asignados en la guía'], 409);
            }

            $oMasterTable->update(
                $request->except(['entries'])
            );

            $entries = collect($request->entries);
            $aCodes = $entries->pluck('code');

            $oldRecords = IncomeForm::where('id_dp_master', $oMasterTable->id)->whereNotIn('code',$aCodes)->get();

            $oldRecordsIndex = 0;
            foreach ($request->validated()['entries'] as $entrie) {
                $oUniqueCode = IncomeForm::whereHas('master', function(Builder $query) use ($request){
                    $query->whereYear('date', $request->date);
                    $query->whereMonth('date', Carbon::createFromFormat('Y-m-d', $request->date)->month);
                })->where(['code' => $entrie['code']])->where('id_dp_master', '!=', $oMasterTable->id)->first();
                if($oUniqueCode) {
                    return $this->errorResponse('The record could not be updated', ['El código debe ser único por día'], 409);
                }

                $existsDailyPayroll = IncomeForm::where(['code' => $entrie['code'], 'id_dp_master' => $oMasterTable->id])->first();
                if($existsDailyPayroll) {
                    $existsDailyPayroll->update($entrie);
                } else {
                    if(array_key_exists($oldRecordsIndex, $oldRecords->toArray())) {
                        $oldRecords[$oldRecordsIndex]->update(array_merge($entrie, [ 'id_guide' => $request->id_guide ]));
                        $oldRecordsIndex += 1;
                    } else {
                        IncomeForm::create(array_merge($entrie, [
                            'id_dp_master' => $oMasterTable->id,
                            'id_guide' => $request->id_guide
                        ]));
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
     * @param  \App\Models\IncomeForm  $incomeForm
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            IncomeForm::where('id_dp_master', $id)->delete();
            DailyPayrollMaster::where('id', $id)->delete();

            return $this->successResponse([], 'Eliminado exitosamente', 200);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }
}
