<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVisceraDispatchRequest;
use App\Http\Resources\VisceraDispatchResource;
use App\Models\VisceraDispatch;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class VisceraDispatchController extends Controller
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
            $visceraDispatch = VisceraDispatch::all();
            return response()->json(VisceraDispatchResource::collection($visceraDispatch));
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
    public function store(StoreVisceraDispatchRequest $request)
    {
        try {
            $visceraDispatch = VisceraDispatch::create($request->validated());
            return $this->successResponse($visceraDispatch, 'Registro realizado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be registered', $exception->getMessage(), 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VisceraDispatch  $visceraDispatch
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $visceraDispatch = VisceraDispatch::find($id);
            return $this->successResponse(VisceraDispatchResource::make($visceraDispatch), 'Listado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VisceraDispatch  $visceraDispatch
     * @return \Illuminate\Http\Response
     */
    public function edit(VisceraDispatch $visceraDispatch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VisceraDispatch  $visceraDispatch
     * @return \Illuminate\Http\Response
     */
    public function update(StoreVisceraDispatchRequest $request, $id)
    {
        try {
            $visceraDispatch = VisceraDispatch::findOrFail($id);        
            $visceraDispatch->update($request->validated());
            return $this->successResponse($visceraDispatch, 'Actualizado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VisceraDispatch  $visceraDispatch
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $visceraDispatch = VisceraDispatch::find($id);
            $visceraDispatch->delete();
            return $this->successResponse($visceraDispatch, 'Eliminado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }
}
