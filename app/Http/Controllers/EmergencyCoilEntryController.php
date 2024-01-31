<?php

namespace App\Http\Controllers;

use App\Exports\EmergencyCoilEntryExport;
use App\Http\Requests\StoreEmergencyCoilEntryRequest;
use App\Http\Resources\EmergencyCoilEntryResource;
use App\Models\EmergencyCoilEntry;
use App\Traits\ApiResponse;
use Maatwebsite\Excel\Facades\Excel;

class EmergencyCoilEntryController extends Controller
{
    use ApiResponse;
    public function index () 
    {
        try {
            $emergencyCoilEntry = EmergencyCoilEntry::all();
            return $this->successResponse(EmergencyCoilEntryResource::collection($emergencyCoilEntry));
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    public function store (StoreEmergencyCoilEntryRequest $request) 
    {
        try {
            $emergencyCoilEntry = EmergencyCoilEntry::create($request->validated());
            return $this->successResponse($emergencyCoilEntry, 'Registro realizado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be registered', $exception->getMessage(), 422);
        }
    }

    public function show (EmergencyCoilEntry $emergencyCoilEntry)
    {
        try {
            return $this->successResponse(EmergencyCoilEntryResource::make($emergencyCoilEntry), 'Listado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    public function update (StoreEmergencyCoilEntryRequest $request, EmergencyCoilEntry $emergencyCoilEntry)
    {
        try {   
            $emergencyCoilEntry->update($request->validated());
            return $this->successResponse($emergencyCoilEntry, 'Actualizado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    public function destroy (EmergencyCoilEntry $emergencyCoilEntry)
    {
        try {
            $emergencyCoilEntry->delete();
            return $this->successResponse($emergencyCoilEntry, 'Eliminado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }

    public function download($id)
    {
        try {
            $emergencyCoilEntry = EmergencyCoilEntry::find($id);
            $emergencyCoilEntryResource = EmergencyCoilEntryResource::make($emergencyCoilEntry);
            $resultArray = json_decode(json_encode($emergencyCoilEntryResource), true);
            $config['signature'] = $emergencyCoilEntry->owner->person->signature;
            return Excel::download(new EmergencyCoilEntryExport(collect($resultArray), $config), 'invoices.xlsx');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }
}
