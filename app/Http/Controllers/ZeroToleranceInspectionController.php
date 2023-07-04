<?php

namespace App\Http\Controllers;

use App\Exports\ZeroToleranceInspectionExport;
use App\Http\Requests\StoreZeroToleranceInspectionRequest;
use App\Http\Resources\ZeroToleranceInspectionResource;
use App\Models\ZeroToleranceInspection;
use App\Traits\ApiResponse;
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
            return response()->json(ZeroToleranceInspectionResource::collection($zeroToleranceInspection));
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
            $zeroToleranceInspection = ZeroToleranceInspection::create($request->validated());
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
            return $this->successResponse($zeroToleranceInspection, 'Eliminado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }

    public function download(Request $request)
    {
        try {
            $zeroToleranceInspection = ZeroToleranceInspection::where('id_master', $request->id_master)->get();
            $zeroToleranceInspection = ZeroToleranceInspectionResource::collection($zeroToleranceInspection);
            return Excel::download(new ZeroToleranceInspectionExport($zeroToleranceInspection), 'invoices.xlsx');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }
}
