<?php

namespace App\Http\Controllers;

use App\Exports\ZeroGutsToleranceExport;
use App\Helpers\FormatDateHelper;
use App\Http\Requests\StoreZeroGutsToleranceRequest;
use App\Http\Resources\ZeroGutsToleranceResource;
use App\Models\GeneralParam;
use App\Models\MasterTable;
use App\Models\ZeroGutsTolerance;
use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ZeroGutsToleranceController extends Controller
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
            $inspections = ZeroGutsTolerance::all();
            return $this->successResponse(ZeroGutsToleranceResource::collection($inspections));
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
    public function store(StoreZeroGutsToleranceRequest $request)
    {
        try {
            DB::beginTransaction();
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
            DB::commit();
            $inspections = ZeroGutsTolerance::create(array_merge($request->validated(), ['id_master' => $master->id]));
            return $this->successResponse($inspections, 'Registro realizado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be registered', $exception->getMessage(), 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ZeroGutsTolerance  $zeroGutsTolerance
     * @return \Illuminate\Http\Response
     */
    public function show(ZeroGutsTolerance $zeroGutsTolerance)
    {
        try {
            return $this->successResponse(ZeroGutsToleranceResource::make($zeroGutsTolerance), 'Listado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ZeroGutsTolerance  $zeroGutsTolerance
     * @return \Illuminate\Http\Response
     */
    public function update(StoreZeroGutsToleranceRequest $request, $id)
    {
        try {
            $zeroGutsTolerance = ZeroGutsTolerance::findOrFail($id);       
            $zeroGutsTolerance->master->update(['date' => $request->date, 'id_specie' => $request->id_specie]); 
            $zeroGutsTolerance->update($request->validated());
            return $this->successResponse($zeroGutsTolerance, 'Actualizado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ZeroGutsTolerance  $zeroGutsTolerance
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $zeroGutsTolerance = ZeroGutsTolerance::find($id);
            $zeroGutsTolerance->delete();
            if(count($zeroGutsTolerance->master->zeroGutsTolerances) <= 1) {
                $zeroGutsTolerance->master->delete();
            }
            return $this->successResponse($zeroGutsTolerance, 'Eliminado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }

    public function download(Request $request)
    {
        try {
            $zeroGutsTolerance = ZeroGutsTolerance::whereHas('master', function (Builder $query) use ($request) {
                $query->where('date', $request->date);
            })->get();
            $zeroGutsTolerance = ZeroGutsToleranceResource::collection($zeroGutsTolerance);

            if(!count($zeroGutsTolerance)) {
                return $this->errorResponse('The report could not be showed', ['There are not records saved']);
            }

            $general['date'] = FormatDateHelper::onGetTextDate($request->date);
            $general['specie'] = $zeroGutsTolerance[0]->master->specie?->name;

            $general['elaborated_by'] = $zeroGutsTolerance[0]?->master->quality_assistant;
            $general['verified_by'] = $zeroGutsTolerance[0]?->master->assistant_veterinarian;

            return Excel::download(new ZeroGutsToleranceExport($zeroGutsTolerance, $general), 'invoices.xlsx');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }
}
