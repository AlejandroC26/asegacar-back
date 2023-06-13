<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostmoremInspectionsRequest;
use App\Http\Resources\PostmortemInspectionsResource;
use App\Models\Causes;
use App\Models\PostmortemInspections;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class PostmortemInspectionsController extends Controller
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
            $inspections = PostmortemInspections::all();
            return response()->json(PostmortemInspectionsResource::collection($inspections));
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
            $inspections = PostmortemInspections::create($request->validated());
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
    public function update(StorePostmoremInspectionsRequest $request, $id)
    {
        try {
            $inspections = PostmortemInspections::findOrFail($id);        
            $inspections->update($request->validated());
            return $this->successResponse($inspections, 'Actualizado exitosamente');
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
}
