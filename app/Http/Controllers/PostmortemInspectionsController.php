<?php

namespace App\Http\Controllers;

use App\Exports\PostmortemInspectionExport;
use App\Helpers\FormatDateHelper;
use App\Http\Requests\StorePostmoremInspectionsRequest;
use App\Http\Requests\UpdatePostmoremInspectionsRequest;
use App\Http\Resources\PostmortemInspectionsResource;
use App\Models\Causes;
use App\Models\GeneralParam;
use App\Models\PostmortemInspections;
use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PostmortemInspectionsController extends Controller
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
            $inspections = PostmortemInspections::all();
            return $this->successResponse(PostmortemInspectionsResource::collection($inspections));
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
    public function store(StorePostmoremInspectionsRequest $request)
    {
        try {
            $responsable_id = GeneralParam::onGetResponsable();
            if(!$responsable_id) {
                return $this->errorResponse('The record could not be saved', ['Configura un responsable en la tabla de firmas para continuar'], 409);
            }
            $inspections = PostmortemInspections::create(array_merge($request->validated(), ['id_responsable' => $responsable_id]));
            return $this->successResponse($inspections, 'Registro realizado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be registered', $exception->getMessage(), 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PostmortemInspections  $inspections
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $inspections = PostmortemInspections::find($id);
            return $this->successResponse(PostmortemInspectionsResource::make($inspections), 'Listado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PostmortemInspections  $inspections
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostmoremInspectionsRequest $request, PostmortemInspections $postmortemInspection)
    {
        try {
            $postmortemInspection->update($request->validated());
            return $this->successResponse($postmortemInspection, 'Actualizado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PostmortemInspections  $inspections
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $inspections = PostmortemInspections::find($id);
            $inspections->delete();
            return $this->successResponse($inspections, 'Eliminado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }

    public function sltCauses()
    {
        try {
            $causes = Causes::select('id','name')->get();
            return response()->json($causes);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }

    public function download(Request $request)
    {
        try {
            $inspections = PostmortemInspections::where('date', $request->date)->get();
            $inspections = PostmortemInspectionsResource::collection($inspections);

            if(!count($inspections)) {
                return $this->errorResponse('The report could not be showed', ['There are not records saved']);
            }

            $general['date'] = FormatDateHelper::onGetTextDate($request->date);
            $general['responsable'] = $inspections[0]?->responsable?->fullname;

            return Excel::download(new PostmortemInspectionExport($inspections, '', '', $general), 'invoices.xlsx');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }
}
