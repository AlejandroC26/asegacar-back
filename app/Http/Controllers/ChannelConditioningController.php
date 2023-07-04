<?php

namespace App\Http\Controllers;

use App\Exports\ChannelConditioningExport;
use App\Http\Requests\StoreChannelConditioningRequest;
use App\Http\Resources\ChannelConditioningResource;
use App\Models\ChannelConditioning;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ChannelConditioningController extends Controller
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
            $channelConditioning = ChannelConditioning::all();
            return response()->json(ChannelConditioningResource::collection($channelConditioning));
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
    public function store(StoreChannelConditioningRequest $request)
    {
        try {
            $channelConditioning = ChannelConditioning::create($request->validated());
            return $this->successResponse($channelConditioning, 'Registro realizado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be registered', $exception->getMessage(), 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ChannelConditioning  $channelConditioning
     * @return \Illuminate\Http\Response
     */
    public function show(ChannelConditioning $channelConditioning)
    {
        try {
            return $this->successResponse(ChannelConditioningResource::make($channelConditioning), 'Listado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ChannelConditioning  $channelConditioning
     * @return \Illuminate\Http\Response
     */
    public function update(StoreChannelConditioningRequest $request, ChannelConditioning $channelConditioning)
    {
        try {     
            $channelConditioning->update($request->validated());
            return $this->successResponse($channelConditioning, 'Actualizado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ChannelConditioning  $channelConditioning
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChannelConditioning $channelConditioning)
    {
        try {     
            $channelConditioning->delete();
            return $this->successResponse($channelConditioning, 'Eliminado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }

    public function download(Request $request)
    {
        try {
            $channelConditioning = ChannelConditioning::where('id_master', $request->id_master)->get();
            $channelConditioning = ChannelConditioningResource::collection($channelConditioning);
            return Excel::download(new ChannelConditioningExport($channelConditioning), 'invoices.xlsx');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }
}
