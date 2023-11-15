<?php

namespace App\Http\Controllers;

use App\Exports\ChannelConditioningExport;
use App\Http\Requests\StoreChannelConditioningRequest;
use App\Http\Resources\ChannelConditioningResource;
use App\Models\ChannelConditioning;
use App\Models\GeneralParam;
use App\Models\MasterTable;
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
            return $this->successResponse(ChannelConditioningResource::collection($channelConditioning));
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
            $errors = [];

            $id_responsable = GeneralParam::onGetResponsable();
            $id_verified_by = GeneralParam::onGetVerifiedBy();
            $id_supervised_by = GeneralParam::onGetSupervisedBy();

            if(!$id_responsable) 
                $errors[] = 'Configura un responsable en la tabla de firmas para continuar';
            if(!$id_verified_by)
                $errors[] = 'Configura a la persona verificadora en la tabla de firmas para continuar';
            if(!$id_supervised_by)
                $errors[] = 'Configura a la persona que elabora en la tabla de firmas para continuar';
            
            if(count($errors)) 
                return $this->errorResponse('The record could not be saved', $errors, 409);

            $master = MasterTable::create(['date' => $request->date, 
                'id_responsable' => $id_responsable,
                'id_verified_by' => $id_verified_by,
                'id_supervised_by' => $id_supervised_by,
                'id_master_type' => 6,
            ]);

            $channelConditioning = ChannelConditioning::create(array_merge($request->validated(), ['id_master' => $master->id]));
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
            if(count($channelConditioning->master->channelConditions) <= 1) {
                $channelConditioning->master->delete();
            }
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
