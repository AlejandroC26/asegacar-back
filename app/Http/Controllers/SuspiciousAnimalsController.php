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
            return response()->json(SuspiciousAnimalsResource::collection($suspiciousAnimals));
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

    public function show (SuspiciousAnimals $suspiciousAnimals)
    {
        try {
            return $this->successResponse(SuspiciousAnimalsResource::make($suspiciousAnimals), 'Listado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    public function update (StoreSuspiciousAnimalsRequest $request, SuspiciousAnimals $suspiciousAnimals)
    {
        try {   
            $suspiciousAnimals->update($request->validated());
            return $this->successResponse($suspiciousAnimals, 'Actualizado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    public function destroy (SuspiciousAnimals $suspiciousAnimals)
    {
        try {
            $suspiciousAnimals->delete();
            return $this->successResponse($suspiciousAnimals, 'Eliminado exitosamente');
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
            return Excel::download(new SuspiciousAnimalsExport(collect($resultArray)), 'invoices.xlsx');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }
}
