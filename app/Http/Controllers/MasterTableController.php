<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMasterTableRequest;
use App\Http\Resources\MasterTableResource;
use App\Models\MasterTable;
use App\Models\MasterType;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class MasterTableController extends Controller
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
            $benefitOrder = MasterTable::with('responsable', 'type')->get();
            return response()->json(MasterTableResource::collection($benefitOrder));
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
    public function store(StoreMasterTableRequest $request)
    {
        try {
            $benefitOrder = MasterTable::create($request->validated());
            return $this->successResponse($benefitOrder, 'Registro realizado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be registered', $exception->getMessage(), 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MasterTable  $masterBenefitOrder
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $masterBenefitOrder = MasterTable::find($id);
            return $this->successResponse($masterBenefitOrder, 'Listado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MasterTable  $masterBenefitOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterTable $masterBenefitOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MasterTable  $masterBenefitOrder
     * @return \Illuminate\Http\Response
     */
    public function update(StoreMasterTableRequest $request, $id)
    {
        try {
            $masterBenefitOrder = MasterTable::findOrFail($id);        
            $masterBenefitOrder->update($request->validated());
            return $this->successResponse($masterBenefitOrder, 'Actualizado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MasterTable  $masterBenefitOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $masterBenefitOrder = MasterTable::find($id);
            $masterBenefitOrder->delete();
            return $this->successResponse($masterBenefitOrder, 'Eliminado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }

    public function sltMaster($idType)
    {
        try {
            $masterBenefitOrder = MasterTable::with('responsable')->where('id_master_type', $idType)->get();
            $masterBenefitOrder = MasterTableResource::toSelect($masterBenefitOrder);
            return response()->json($masterBenefitOrder);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }

    public function sltMasterType()
    {
        try {
            $masterTypes = MasterType::select('id', 'name')->get();
            return response()->json($masterTypes);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }
}
