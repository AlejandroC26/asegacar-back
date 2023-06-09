<?php

namespace App\Http\Controllers;

use App\Exports\DailyPayrollExport;
use App\Http\Requests\StoreDailyPayrollRequest;
use App\Http\Resources\DailyPayrollResource;
use App\Models\DailyPayroll;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DailyPayrollController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $dailyPayroll = DailyPayroll::all();
            return response()->json(DailyPayrollResource::collection($dailyPayroll));
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDailyPayrollRequest $request)
    {
        try {       
            DB::beginTransaction();

            $dailyPayroll = DailyPayroll::create($request->validated()); 

            DB::commit();

            return $this->successResponse($dailyPayroll, 'Registro realizado exitosamente', 200);
        } catch (\Throwable $exception) {
            DB::rollBack();
            return $this->errorResponse('The record could not be registered', $exception->getMessage(), 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $dailyPayroll = DailyPayroll::find($id);
            return $this->successResponse($dailyPayroll, 'Listado exitosamente', 200);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreDailyPayrollRequest $request, $id)
    {
        try {
            
            $validated = $request->validated();
            $validated = $request->safe()->except(['genders', 'colors']); 
            
            $dailyPayroll = DailyPayroll::find($id);
            $dailyPayroll->update($validated);

            return $this->successResponse($dailyPayroll, 'Actualizado exitosamente', 200);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $dailyPayroll = DailyPayroll::find($id);
            $dailyPayroll->delete();

            return $this->successResponse($dailyPayroll, 'Eliminado exitosamente', 200);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }

    public function download(Request $request)
    {
        try { 
            $total_males = 0;
            $total_females = 0;

            $dailyPayroll = DailyPayroll::with('outlet', 'master.responsable')->select(
                    'daily_payrolls.id', 
                    'id_master', 
                    'id_outlet',
                    DB::raw("GROUP_CONCAT(CONCAT(amount,' ', colors.name) SEPARATOR ', ') as colors"),
                    DB::raw("GROUP_CONCAT(CONCAT(amount,' ', genders.name) SEPARATOR ', ') as genders"),
                    DB::raw("SUM(CASE WHEN id_gender = 1 THEN amount END) AS total_males"),
                    DB::raw("SUM(CASE WHEN id_gender = 2 THEN amount END) AS total_females"),
                    'daily_payrolls.created_at'
                )
                ->leftJoin('colors', 'colors.id', '=', 'daily_payrolls.id_color')
                ->leftJoin('genders', 'genders.id', '=', 'daily_payrolls.id_gender')
                ->groupBy('id_outlet')
                ->get();

            $total_males = 0;
            $total_females = 0;
            foreach ($dailyPayroll as $element) {
                $total_males += $element->total_females;
                $total_females += $element->total_females;
            }
            $general = $dailyPayroll[0] ? $dailyPayroll[0]->master : [];
            
            return Excel::download(new DailyPayrollExport($dailyPayroll, $total_males, $total_females, $general), 'invoices.xlsx');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be shoed', $exception->getMessage(), 422);
        }
    }
}
