<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSeizureComparisonRequest;
use App\Http\Resources\SeizureComparisonResource;
use App\Models\SeizureComparison;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

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
            return response()->json(SeizureComparisonResource::collection($seizureComparison));
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            $seizureComparison = SeizureComparison::create($request->validated());
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SeizureComparison  $seizureComparison
     * @return \Illuminate\Http\Response
     */
    public function edit(SeizureComparison $seizureComparison)
    {
        //
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
            return $this->successResponse($seizureComparison, 'Eliminado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }
}
