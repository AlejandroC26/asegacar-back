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
            $dailyPayroll = DailyPayroll::where('benefit_date', $request->date)->get();
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
            $validated = $request->validated();
            $validated = $request->safe()->except(['genders', 'colors']); 
           
            DB::beginTransaction();

            if(!$request->benefit_date) 
                $validated = array_merge($validated, [ "benefit_date" => now() ]);

            $dailyPayroll = DailyPayroll::create($validated); 
            foreach ($request->colors as $color) {
                DB::table('daily_payroll_colors')->insert([
                    'id_daily_payroll' => $dailyPayroll->id,
                    'id_color' => $color['id']
                ]);
            }

            foreach ($request->genders as $gender) {
                DB::table('daily_payroll_genders')->insert([
                    'id_daily_payroll' => $dailyPayroll->id,
                    'id_gender' => $gender['id']
                ]);
            }

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

            $colors = DB::table('daily_payroll_colors')
                ->select('colors.id', 'colors.name')
                ->leftJoin('colors', 'colors.id', 'daily_payroll_colors.id_color')
                ->where(['id_daily_payroll' => $id])
                ->get();

            $genders = DB::table('daily_payroll_genders')
                ->select('genders.id', 'genders.name')
                ->leftJoin('genders', 'genders.id', 'daily_payroll_genders.id_gender')
                ->where(['id_daily_payroll' => $id])
                ->get();

            $dailyPayroll['colors'] = $colors;
            $dailyPayroll['genders'] = $genders;
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

            DB::table('daily_payroll_colors')->where(['id_daily_payroll' => $dailyPayroll->id])->delete();
            foreach ($request->colors as $color) {
                DB::table('daily_payroll_colors')->insert([
                    'id_daily_payroll' => $dailyPayroll->id,
                    'id_color' => $color['id']
                ]);
            }

            DB::table('daily_payroll_genders')->where(['id_daily_payroll' => $dailyPayroll->id])->delete();
            foreach ($request->genders as $gender) {
                DB::table('daily_payroll_genders')->insert([
                    'id_daily_payroll' => $dailyPayroll->id,
                    'id_gender' => $gender['id']
                ]);
            }

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

            DB::table('daily_payroll_colors')->where(['id_daily_payroll' => $dailyPayroll->id])->delete();
            DB::table('daily_payroll_genders')->where(['id_daily_payroll' => $dailyPayroll->id])->delete();

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
            $dailyPayroll = DailyPayroll::where('benefit_date', $request->sacrifice_date)->get();
            foreach ($dailyPayroll as $element) {
                $total_males += $element->total_males;
                $total_females += $element->total_females;
            }

            $dailyPayroll = DailyPayrollResource::collection($dailyPayroll);
            $dailyPayroll = json_decode($dailyPayroll->toJson(), true);
            return Excel::download(new DailyPayrollExport($dailyPayroll, $total_males, $total_females), 'invoices.xlsx');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be shoed', $exception->getMessage(), 422);
        }
    }
}
