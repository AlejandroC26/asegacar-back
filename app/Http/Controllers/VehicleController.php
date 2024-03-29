<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVehicleRequest;
use App\Http\Resources\VehicleResource;
use App\Models\Vehicle;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    use ApiResponse;

    public function index()
    {
        try {
            $vehicles = Vehicle::all();
            return $this->successResponse(VehicleResource::collection($vehicles));
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    public function store(StoreVehicleRequest $request) {
        try {
            $outlet = Vehicle::create($request->validated());
            return $this->successResponse($outlet, 'Registro realizado exitosamente', 200);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be registered', $exception->getMessage(), 422);
        }
    }

    public function show (Vehicle $vehicle) {
        try {
            return $this->successResponse($vehicle, 'Listado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    public function update(StoreVehicleRequest $request, Vehicle $vehicle) {
        try {    
            $vehicle->update($request->validated());
            return $this->successResponse($vehicle, 'Actualizado exitosamente', 200);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    public function sltVehicles() {
        try {
            $vehicles = Vehicle::select('id', 'plate as name')->get();
            return response()->json($vehicles);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }

    public function destroy(Vehicle $vehicle) {
        try {
            $vehicle->delete();
            return $this->successResponse($vehicle, 'Eliminado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }
    
}
