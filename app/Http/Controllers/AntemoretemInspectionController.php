<?php

namespace App\Http\Controllers;

use App\Exports\AntemortemInspectionExport;
use App\Http\Requests\StoreAntemortemInspectionRequest;
use App\Http\Resources\AntemortemInspectionResource;
use App\Models\AntemortemInspection;
use App\Models\InspectionSuspiciousAnimal;
use App\Models\User;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class AntemoretemInspectionController extends Controller
{
    use ApiResponse;
    public function index () 
    {
        try {
            $antemortemInspections = AntemortemInspection::all();
            return $this->successResponse(AntemortemInspectionResource::collection($antemortemInspections));
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
            $time_entry = Carbon::createFromFormat('H:i', $request->time_entry);
            $time_entry = $time_entry->format('H:i:s', $time_entry);
            $antemortemInspection = AntemortemInspection::where([
                'date' => $request->date,
                'id_veterinary' => $request->id_veterinary,
                'time_entry' => $time_entry
            ])->get();

            $antemortemInspectionResource = AntemortemInspectionResource::collection($antemortemInspection);

            if(!count($antemortemInspection)) {
                return $this->errorResponse('Not found', ['No se encontraron registros en esta fecha'], 404);
            } 

            $resultArray = json_decode(json_encode($antemortemInspectionResource), true);

            $guides = collect($resultArray)->pluck('id_guide');
            
            $suspiciousAnimals = InspectionSuspiciousAnimal::whereHas('dailyPayroll.incomeForm', function (Builder $query) use ($guides) {
                $query->whereIn('id_guide', $guides);
            })->get();

            $suspiciousAnimals = $suspiciousAnimals->map(function ($animal) {
                $response['male'] = ($animal->dailyPayroll->incomeForm->id_gender === 1) ? 1 : 0;
                $response['female'] = ($animal->dailyPayroll->incomeForm->id_gender === 2) ? 1 : 0;
                $response['guide'] = $animal->dailyPayroll->incomeForm->guide->code;
                $response['findings_and_observations'] = $animal->findings_and_observations;
                $response['decision'] = $animal->decision;
                $response['cause_forfeiture'] = $animal->cause_forfeiture;
                $response['corral'] = $animal->corral;
                return $response;
            });

            $veterinary = User::find($request->id_veterinary);
            $request->request->add([
                'veterinary' => $veterinary->person->fullname, 
                'suspiciousAnimals' => $suspiciousAnimals
            ]);

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
