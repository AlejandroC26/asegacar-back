<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreZeroGutsToleranceRequest;
use App\Http\Resources\ZeroGutsToleranceResource;
use App\Models\ZeroGutsTolerance;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

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
            return response()->json(ZeroGutsToleranceResource::collection($inspections));
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
            $inspections = ZeroGutsTolerance::create($request->validated());
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
    public function show($id)
    {
        try {
            $zeroGutsTolerance = ZeroGutsTolerance::find($id);
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
            return $this->successResponse($zeroGutsTolerance, 'Eliminado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }

    public function download(Request $request)
    {
        try {
            $zeroGutsTolerance = ZeroGutsTolerance::where('id_master', $request->id_master)->get();
            $zeroGutsTolerance = ZeroGutsToleranceResource::collection($zeroGutsTolerance);
            return $zeroGutsTolerance;
            //return Excel::download(new PostmortemInspectionExport($inspections, '', '', ''), 'invoices.xlsx');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }
}
