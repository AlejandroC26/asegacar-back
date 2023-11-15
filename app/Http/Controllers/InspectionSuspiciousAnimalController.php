<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInspectionSuspiciousAnimalRequest;
use App\Http\Resources\InspectionSuspiciousAnimalResource;
use App\Models\InspectionSuspiciousAnimal;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InspectionSuspiciousAnimalController extends Controller
{
    use ApiResponse;

    public function index()  {
        try {
            $inspectionSuspiciousAnimals = InspectionSuspiciousAnimal::all();
            return $this->successResponse(InspectionSuspiciousAnimalResource::collection($inspectionSuspiciousAnimals));
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    public function store(StoreInspectionSuspiciousAnimalRequest $request)
    {
        try {
            DB::beginTransaction();
            $inspectionSuspiciousAnimal = InspectionSuspiciousAnimal::create($request->validated());
            DB::commit();
            return $this->successResponse($inspectionSuspiciousAnimal, 'Registro realizado exitosamente');
        } catch (\Throwable $exception) {
            DB::rollBack();
            return $this->errorResponse('The record could not be registered', $exception->getMessage(), 422);
        }
    }

    public function show(InspectionSuspiciousAnimal $inspectionSuspiciousAnimal)
    {
        try {
            return $this->successResponse(InspectionSuspiciousAnimalResource::make($inspectionSuspiciousAnimal), 'Listado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    public function update(StoreInspectionSuspiciousAnimalRequest $request, InspectionSuspiciousAnimal $inspectionSuspiciousAnimal)
    {
        try {
            DB::beginTransaction();
            $inspectionSuspiciousAnimal->update($request->validated());
            DB::commit();
            return $this->successResponse($inspectionSuspiciousAnimal, 'Actualizado exitosamente');
        } catch (\Throwable $exception) {
            DB::rollBack();
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    public function destroy(InspectionSuspiciousAnimal $inspectionSuspiciousAnimal)
    {
        try {
            DB::beginTransaction();
            $inspectionSuspiciousAnimal->delete();
            DB::commit();
            return $this->successResponse($inspectionSuspiciousAnimal, 'Eliminado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }
}
