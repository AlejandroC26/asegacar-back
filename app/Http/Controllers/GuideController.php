<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGuideRequest;
use App\Http\Requests\UpdateGuideRequest;
use App\Http\Resources\GuideResource;
use App\Models\DailyPayrollMaster;
use App\Models\Guide;
use App\Models\Specie;
use App\Traits\ApiResponse;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GuideController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $guides = Guide::all();
            return $this->successResponse(GuideResource::collection($guides));
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
    public function store(StoreGuideRequest $request)
    {
        try {
            $sFileName = '';
            $consecutive = '';

            $tomorrowDate = Carbon::now()->addDay();
            $tomorrowDate->setTimezone('UTC');
            $tomorrowDateCopy = $tomorrowDate->copy();

            $lastDayOfLastMonth = $tomorrowDateCopy->subMonthNoOverflow()->endOfMonth()->startOfDay();
            $lastDayOfMonth = $tomorrowDate->endOfMonth();
            
            $monthGuides = Guide::select(DB::raw('MAX(CAST(SUBSTRING_INDEX(consecutive, " - ", -1) AS UNSIGNED)) AS max_number'))
                ->whereBetween('created_at', [$lastDayOfLastMonth, $lastDayOfMonth])
                ->first();

            $monthAnimals = $monthGuides?->max_number ?? 0;
            $consecutive = $monthAnimals+1 .' - '. $monthAnimals + $request->no_animals;
            
            if($request->file('file_attached')) {
                $sFileName = 'guide'.date("Ymd_Hms").'.'.$request->file('file_attached')->extension();
                $request->file('file_attached')->storeAs('public/guide', $sFileName);
            }  
            $guide = Guide::create(array_merge($request->validated(), [
                'file_attached' => $sFileName,
                'consecutive' => $consecutive
            ]));
            return $this->successResponse($guide, 'Registro realizado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be registered', $exception->getMessage(), 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Guide $guide)
    {
        try {
            return $this->successResponse(GuideResource::make($guide), 'Listado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGuideRequest $request, Guide $guide)
    {
        try {   
            $sFileName = $guide->file_attached;
            if($request->file('file_attached')) {
                $sFileName = $sFileName ? $sFileName : 'guide'.date("Ymd_Hms").'.'.$request->file('file_attached')->extension();
                $request->file('file_attached')->storeAs('public/guide', $sFileName);
            }  
            $guide->update(array_merge($request->validated(), ['file_attached' => $sFileName]));
            return $this->successResponse($guide, 'Actualizado exitosamente');
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
    public function destroy(Guide $guide)
    {
        try {
            $guide->delete();
            return $this->successResponse($guide, 'Eliminado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }

    public function sltGuides () {
        try {
            $guides = Guide::select('id', 'code as name')->get();
            return response()->json($guides);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    public function sltGuideForIncomeForm($sDate) {
        try {
            $guides = Guide::select('id', 'code as name')->has('incomeForms', '<', DB::raw('no_animals'))->where('date_entry', $sDate)->get();
            return response()->json($guides);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    public function sltGuideForDailyPayroll($sDate) {
        try {
            $guides = DailyPayrollMaster::select('daily_payroll_master.id', 'guides.code as name')
                ->leftJoin('income_forms', 'income_forms.id_dp_master', 'daily_payroll_master.id')
                ->leftJoin('daily_payrolls', 'daily_payrolls.id_income_form', 'income_forms.id')
                ->leftJoin('guides', 'guides.id', 'income_forms.id_guide')
                ->where('guides.date_entry', $sDate)
                ->groupBy('daily_payroll_master.id', 'guides.id')
                ->having(DB::raw('count(daily_payrolls.id)'), '<=', '0')
                ->get();
            
            return response()->json($guides);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }
    
    public function dailyPayrollGuides($id) {
        try {
            $oMaster = DailyPayrollMaster::find($id);
            return $this->successResponse(GuideResource::make($oMaster->incomeForms[0]->guide));
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    public function sltGuideThroughMaster($relation, $date) {
        try {
            $qurey = DB::table('guides')
                ->select('guides.id', 'guides.code as name', 'guides.no_animals as total', DB::raw("COUNT($relation.id) as serach_total"))
                ->leftJoin('income_forms', 'income_forms.id_guide', 'guides.id')
                ->leftJoin('daily_payrolls', 'income_forms.id', 'daily_payrolls.id_income_form')
                ->leftJoin($relation, "$relation.id_daily_payroll", 'daily_payrolls.id');

            if($date != "false") 
                $qurey = $qurey->where('guides.date_entry', $date);

            $guides = $qurey->groupBy('guides.id', 'guides.code', 'guides.no_animals')
                ->havingRaw('serach_total < guides.no_animals')
                ->get();
                
            return response()->json($guides);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }
    

    public function sltSpecies () {
        try {
            $guides = Specie::select('id', 'name')->get();
            return response()->json($guides);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    public function downloadGuide($id) {
        try {
            $oGuide = Guide::find($id);
            if(!$oGuide->file_attached) {
                return $this->errorResponse("File doesnt't found", ["The file does not found"]);
            }
            $sPath = storage_path('app/public/guide/'.$oGuide->file_attached);
            $headers = [ 'Content-Type' => 'application/pdf' ];
            return response()->download($sPath, 'guide.pdf', $headers);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    public function generatePDF($id)
    {
        try {
            $guide = Guide::find($id);
            $data['person'] = $guide->owner;
            $data['guide'] = $guide->code;
            $pdf =  Pdf::loadView('pdf.contract', $data);
            return $pdf->download('Contrato-deposito-animales.pdf');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }
}
