<?php

namespace App\Http\Controllers;

use App\Exports\ParturientFemalesExport;
use App\Http\Requests\StoreParturientFemalesRequest;
use App\Http\Resources\ParturiantFemalesResource;
use App\Models\ParturientFemales;
use App\Traits\ApiResponse;
use Maatwebsite\Excel\Facades\Excel;

class ParturientFemalesController extends Controller
{
    use ApiResponse;
    public function index () 
    {
        try {
            $parturientFemales = ParturientFemales::all();
            return response()->json(ParturiantFemalesResource::collection($parturientFemales));
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    public function store (StoreParturientFemalesRequest $request) 
    {
        try {
            $parturientFemale = ParturientFemales::create($request->validated());
            return $this->successResponse($parturientFemale, 'Registro realizado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be registered', $exception->getMessage(), 422);
        }
    }

    public function show (ParturientFemales $parturientFemale)
    {
        try {
            return $this->successResponse(ParturiantFemalesResource::make($parturientFemale), 'Listado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    public function update (StoreParturientFemalesRequest $request, ParturientFemales $parturientFemale)
    {
        try {   
            $parturientFemale->update($request->validated());
            return $this->successResponse($parturientFemale, 'Actualizado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    public function destroy (ParturientFemales $parturientFemale)
    {
        try {
            $parturientFemale->delete();
            return $this->successResponse($parturientFemale, 'Eliminado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }

    public function download($id)
    {
        try {
            $parturientFemale = ParturientFemales::find($id);
            $parturientFemaleResource = ParturiantFemalesResource::make($parturientFemale);
            $resultArray = json_decode(json_encode($parturientFemaleResource), true);
            return Excel::download(new ParturientFemalesExport(collect($resultArray)), 'invoices.xlsx');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }
}
