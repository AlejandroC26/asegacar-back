<?php

namespace App\Http\Controllers;

use App\Exports\ZeroToleranceInspectionExport;
use App\Helpers\FormatDateHelper;
use App\Http\Requests\StoreZeroToleranceInspectionRequest;
use App\Http\Resources\ChannelConditioningResource;
use App\Http\Resources\ZeroToleranceInspectionResource;
use App\Models\ChannelConditioning;
use App\Models\GeneralParam;
use App\Models\MasterTable;
use App\Models\ZeroToleranceInspection;
use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ZeroToleranceInspectionController extends Controller
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
            $zeroToleranceInspection = ZeroToleranceInspection::all();
            return $this->successResponse(ZeroToleranceInspectionResource::collection($zeroToleranceInspection));
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
    public function store(StoreZeroToleranceInspectionRequest $request)
    {
        try {
            $errors = [];

            $id_assistant_veterinarian = GeneralParam::onGetGeneralParamByName('id_assistant_veterinarian');
            $id_quality_assistant = GeneralParam::onGetGeneralParamByName('id_quality_assistant');
            $id_quality_manager = GeneralParam::onGetGeneralParamByName('id_quality_assistant');

            if(!$id_assistant_veterinarian)
                $errors[] = 'Configura un medico veterinario auxiliar en la tabla de firmas para continuar';
            if(!$id_quality_assistant)
                $errors[] = 'Configura un asistente de calidad en la tabla de firmas para continuar';
            if(!$id_quality_manager)
                $errors[] = 'Configura un jefe de calidad en la tabla de firmas para continuar';
            
            if(count($errors)) 
                return $this->errorResponse('The record could not be saved', $errors, 409);

            $master = MasterTable::create(['date' => $request->date, 
                'id_assistant_veterinarian' => $id_assistant_veterinarian,
                'id_quality_assistant' => $id_quality_assistant,
                'id_quality_manager' => $id_quality_manager,
                'id_specie' => $request->id_specie,
                'id_master_type' => 4,
            ]);

            $zeroToleranceInspection = ZeroToleranceInspection::create(array_merge($request->validated(), ['id_master' => $master->id]));
            return $this->successResponse($zeroToleranceInspection, 'Registro realizado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be registered', $exception->getMessage(), 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ZeroToleranceInspection  $zeroToleranceInspection
     * @return \Illuminate\Http\Response
     */
    public function show(ZeroToleranceInspection $zeroToleranceInspection)
    {
        try {
            return $this->successResponse(ZeroToleranceInspectionResource::make($zeroToleranceInspection), 'Listado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ZeroToleranceInspection  $zeroToleranceInspection
     * @return \Illuminate\Http\Response
     */
    public function update(StoreZeroToleranceInspectionRequest $request, ZeroToleranceInspection $zeroToleranceInspection)
    {
        try {     
            $zeroToleranceInspection->master->update(['date' => $request->date]); 
            $zeroToleranceInspection->update($request->validated());
            return $this->successResponse($zeroToleranceInspection, 'Actualizado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ZeroToleranceInspection  $zeroToleranceInspection
     * @return \Illuminate\Http\Response
     */
    public function destroy(ZeroToleranceInspection $zeroToleranceInspection)
    {
        try {     
            $zeroToleranceInspection->delete();
            if(count($zeroToleranceInspection->master->zeroToleranceInspections) <= 1) {
                $zeroToleranceInspection->master->delete();
            }
            return $this->successResponse($zeroToleranceInspection, 'Eliminado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }

    public function download(Request $request)
    {
        try {
            $zeroToleranceInspection = ZeroToleranceInspection::whereHas('master', function (Builder $query) use ($request) {
                $query->where('date', $request->date);
            })->get();
            $zeroToleranceInspection = ZeroToleranceInspectionResource::collection($zeroToleranceInspection);

            $channelConditioning = ChannelConditioning::whereHas('master', function (Builder $query) use ($request) {
                $query->where('date', $request->date);
            })->get();
            $channelConditioning = ChannelConditioningResource::collection($channelConditioning);

            if(!count($zeroToleranceInspection) && !count($channelConditioning)) {
                return $this->errorResponse('The report could not be showed', ['There are not records saved']);
            }

            $general['date'] = FormatDateHelper::onGetTextDate($request->date);
            $general['supervised_by'] = $zeroToleranceInspection[0]?->master->assistant_veterinarian;
            $general['verified_by'] = $zeroToleranceInspection[0]?->master->quality_manager;
            $general['responsable'] = $zeroToleranceInspection[0]?->master->quality_assistant->fullname;

            return Excel::download(new ZeroToleranceInspectionExport([
                'zeroToleranceInspection' => $zeroToleranceInspection,
                'channelConditioning' => $channelConditioning
            ], $general), 'invoices.xlsx');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }
}
