<?php

namespace App\Http\Controllers;

use App\Exports\SuspiciousAnimalsExport;
use App\Http\Requests\StoreSuspiciousAnimalsRequest;
use App\Http\Resources\SuspiciousAnimalsResource;
use App\Models\SuspiciousAnimals;
use App\Traits\ApiResponse;
use Maatwebsite\Excel\Facades\Excel;

class SuspiciousAnimalsController extends Controller
{
    use ApiResponse;

    public function index () 
    {
        try {
            $suspiciousAnimals = SuspiciousAnimals::all();
            return $this->successResponse(SuspiciousAnimalsResource::collection($suspiciousAnimals));
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    public function store (StoreSuspiciousAnimalsRequest $request) 
    {
        try {
            $suspiciousAnimals = SuspiciousAnimals::create($request->validated());
            return $this->successResponse($suspiciousAnimals, 'Registro realizado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be registered', $exception->getMessage(), 422);
        }
    }

    public function show (SuspiciousAnimals $suspiciousAnimal)
    {
        try {
            return $this->successResponse(SuspiciousAnimalsResource::make($suspiciousAnimal), 'Listado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    public function update (StoreSuspiciousAnimalsRequest $request, SuspiciousAnimals $suspiciousAnimal)
    {
        try {   
            $suspiciousAnimal->update($request->validated());
            return $this->successResponse($suspiciousAnimal, 'Actualizado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    public function destroy (SuspiciousAnimals $suspiciousAnimal)
    {
        try {
            $suspiciousAnimal->delete();
            return $this->successResponse($suspiciousAnimal, 'Eliminado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }

    public function download($id)
    {
        try {
            $suspiciousAnimals = SuspiciousAnimals::find($id);
            $suspiciousAnimalsResource = SuspiciousAnimalsResource::make($suspiciousAnimals);
            $resultArray = json_decode(json_encode($suspiciousAnimalsResource), true);
            $config['signature'] = $suspiciousAnimals->owner->person->signature;
            return Excel::download(new SuspiciousAnimalsExport(collect($resultArray), $config), 'invoices.xlsx');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }
}
