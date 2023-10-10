<?php

namespace App\Http\Controllers;

use App\Exports\AntemortemInspectionExport;
use App\Http\Requests\StoreAntemortemInspectionRequest;
use App\Http\Resources\AntemortemInspectionResource;
use App\Models\AntemortemInspection;
use App\Models\User;
use App\Traits\ApiResponse;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class AntemoretemInspectionController extends Controller
{
    use ApiResponse;
    public function index () 
    {
        try {
            $antemortemInspections = AntemortemInspection::all();
            return response()->json(AntemortemInspectionResource::collection($antemortemInspections));
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    public function store (StoreAntemortemInspectionRequest $request) 
    {
        try {
            $antemortemInspection = AntemortemInspection::create($request->validated());
            return $this->successResponse($antemortemInspection, 'Registro realizado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be registered', $exception->getMessage(), 422);
        }
    }

    public function show (AntemortemInspection $antemortemInspection)
    {
        try {
            return $this->successResponse(AntemortemInspectionResource::make($antemortemInspection), 'Listado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }
    
    public function update (StoreAntemortemInspectionRequest $request, AntemortemInspection $antemortemInspection)
    {
        try {   
            $antemortemInspection->update($request->validated());
            return $this->successResponse($antemortemInspection, 'Actualizado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    public function destroy (AntemortemInspection $antemortemInspection)
    {
        try {
            $antemortemInspection->delete();
            return $this->successResponse($antemortemInspection, 'Eliminado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }

    public function download(Request $request)
    {
        try {
            $antemortemInspection = AntemortemInspection::where($request->only(['date', 'id_veterinary', 'time_entry']))->get();
            $antemortemInspectionResource = AntemortemInspectionResource::collection($antemortemInspection);
            $resultArray = json_decode(json_encode($antemortemInspectionResource), true);

            $veterinary = User::find($request->id_veterinary);

            $request->request->add(['veterinary' => $veterinary->person->fullname]);

            return Excel::download(new AntemortemInspectionExport($request, collect($resultArray)), 'invoices.xlsx');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    public function sltAntemortemVeterinary()
    {
        try {
            $users = AntemortemInspection::select('users.id', 'persons.fullname as name')
                ->join('users', 'id_veterinary', 'users.id')
                ->join('persons', 'persons.id', 'users.id_person')
                ->groupBy('id_veterinary')
                ->get();
            return response()->json($users);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }
    
}
