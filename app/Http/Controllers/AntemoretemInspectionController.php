<?php

namespace App\Http\Controllers;

use App\Exports\AntemortemInspectionExport;
use App\Http\Requests\StoreAntemortemInspectionRequest;
use App\Http\Requests\UpdateAntemortemInspectionRequest;
use App\Http\Resources\AntemortemInspectionResource;
use App\Models\AntemortemInspection;
use App\Models\GeneralParam;
use App\Models\User;
use App\Traits\ApiResponse;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AntemoretemInspectionController extends Controller
{
    use ApiResponse;
    public function index () 
    {
        try {
            $antemortemInspections = AntemortemInspection::select('antemortem_inspection.id', 'antemortem_inspection.date', 'guides.code', DB::raw('count(*) as entries'))
                ->leftJoin('daily_payrolls', 'daily_payrolls.id', '=', 'antemortem_inspection.id_daily_payroll')
                ->leftJoin('income_forms', 'income_forms.id', '=', 'daily_payrolls.id_income_form')
                ->leftJoin('guides', 'guides.id', '=', 'income_forms.id_guide')
                ->groupBy('antemortem_inspection.date', 'guides.code')
                ->get();
            return $this->successResponse($antemortemInspections);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    public function store (StoreAntemortemInspectionRequest $request) 
    {
        try {
            DB::beginTransaction();
            $id_veterinary = GeneralParam::onGetVeterinary();
            foreach ($request->validated()['entries'] as $entrie) {
                AntemortemInspection::create(array_merge($entrie, [
                    'id_daily_payroll' => $entrie['id'],
                    'date' => $request->date,
                    'id_veterinary' => $id_veterinary
                ]));
            }
            DB::commit();
            return $this->successResponse([], 'Registro realizado exitosamente');
        } catch (\Throwable $exception) {
            DB::rollBack();
            return $this->errorResponse('The record could not be registered', $exception->getMessage(), 422);
        }
    }

    public function show (AntemortemInspection $antemortemInspection)
    {
        try {
            return $this->successResponse(AntemortemInspectionResource::toShow($antemortemInspection), 'Listado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }
    
    public function update (UpdateAntemortemInspectionRequest $request)
    {
        try {   
            DB::beginTransaction();
            foreach ($request->validated()['entries'] as $entrie) {
                $update['date'] = $request->date;
                $update['corral_number'] = $entrie['corral_number'];
                $update['corral_entry'] = $entrie['corral_entry'];
                $update['rest_time'] = $entrie['rest_time'];
                $update['findings_and_observations'] = $entrie['findings_and_observations'];
                $update['final_dictament'] = $entrie['final_dictament'];
                $update['cause_for_seizure'] = $entrie['cause_for_seizure'];
                AntemortemInspection::where('id', $entrie['id'])->update($update);
            }
            DB::commit();
            return $this->successResponse([], 'Actualizado exitosamente');
        } catch (\Throwable $exception) {
            DB::rollBack();
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
            $antemortemInspection = AntemortemInspection::where(['date' => $request->date])->whereHas('dailyPayroll', function($query) {
                $query->whereNotNull('sacrifice_date');
            })->get();

            if(!count($antemortemInspection)) {
                return $this->errorResponse('Not found', ['No se encontraron registros en esta fecha'], 404);
            } 

            $count['males'] = 0;
            $count['females'] = 0;
            foreach ($antemortemInspection as $inspection) {
                $gender = $inspection->dailyPayroll->incomeForm->gender->id;
                $count['males'] += $gender == 1;
                $count['females'] += $gender == 2;
            }

            $veterinary = User::find($antemortemInspection[0]->id_veterinary);
            $request->request->add([
                'veterinary' => $veterinary->person->fullname, 
                'count' => $count,
                'total' => $antemortemInspection->count()
            ]);

            return Excel::download(new AntemortemInspectionExport($request, $antemortemInspection), 'invoices.xlsx');
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
