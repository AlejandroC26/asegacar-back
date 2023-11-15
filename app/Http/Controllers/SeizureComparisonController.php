<?php

namespace App\Http\Controllers;

use App\Exports\SeizureComparisonExport;
use App\Helpers\FormatDateHelper;
use App\Http\Requests\StoreSeizureComparisonRequest;
use App\Http\Resources\SeizureComparisonResource;
use App\Models\GeneralParam;
use App\Models\MasterTable;
use App\Models\SeizureComparison;
use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SeizureComparisonController extends Controller
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
            $seizureComparison = SeizureComparison::all();
            return $this->successResponse(SeizureComparisonResource::collection($seizureComparison));
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
    public function store(StoreSeizureComparisonRequest $request)
    {
        try {

            $errors = [];

            $id_responsable = GeneralParam::onGetResponsable();
            $id_supervised_by = GeneralParam::onGetSupervisedBy();

            if(!$id_responsable) 
                $errors[] = 'Configura un responsable en la tabla de firmas para continuar';
            if(!$id_supervised_by)
                $errors[] = 'Configura a la persona que elabora en la tabla de firmas para continuar';
            
            if(count($errors)) 
                return $this->errorResponse('The record could not be saved', $errors, 409);

            $master = MasterTable::create(['date' => $request->date, 
                'id_responsable' => $id_responsable,
                'id_supervised_by' => $id_supervised_by,
                'id_master_type' => 8,
            ]);

            $seizureComparison = SeizureComparison::create(array_merge($request->validated(), ['id_master' => $master->id]));
            return $this->successResponse($seizureComparison, 'Registro realizado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be registered', $exception->getMessage(), 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SeizureComparison  $seizureComparison
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $seizureComparison = SeizureComparison::find($id);
            return $this->successResponse(SeizureComparisonResource::make($seizureComparison), 'Listado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SeizureComparison  $seizureComparison
     * @return \Illuminate\Http\Response
     */
    public function update(StoreSeizureComparisonRequest $request, $id)
    {
        try {
            $seizureComparison = SeizureComparison::findOrFail($id);       
            $seizureComparison->master->update(['date' => $request->date]);  
            $seizureComparison->update($request->validated());
            return $this->successResponse($seizureComparison, 'Actualizado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SeizureComparison  $seizureComparison
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $seizureComparison = SeizureComparison::find($id);
            $seizureComparison->delete();
            if(count($seizureComparison->master->seizureComparisons) <= 1) {
                $seizureComparison->master->delete();
            }
            return $this->successResponse($seizureComparison, 'Eliminado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }

    public function download(Request $request)
    {
        try {
            $seizureComparison = SeizureComparison::whereHas('master', function (Builder $query) use ($request) {
                $query->where('date', $request->date);
            })->get();

            $seizureComparison = SeizureComparisonResource::collection($seizureComparison);

            if(!count($seizureComparison)) {
                return $this->errorResponse('The report could not be showed', ['There are not records saved']);
            }

            $general['date'] = FormatDateHelper::onGetTextDate($request->date);
            $general['supervised_by'] = $seizureComparison[0]?->master->supervised_by->fullname;
            $general['responsable'] = $seizureComparison[0]?->master->responsable->fullname;

            return Excel::download(new SeizureComparisonExport($seizureComparison, $general), 'invoices.xlsx');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }
}
