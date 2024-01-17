<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOutletRequest;
use App\Http\Resources\OutletResource;
use App\Models\DailyPayroll;
use App\Models\Outlet;
use App\Models\PostmortemInspections;
use App\Models\SeizureComparison;
use App\Traits\ApiResponse;

class OutletController extends Controller
{
    use ApiResponse;

    public function index()
    {
        try {
            $outlets = Outlet::all();
            return $this->successResponse(OutletResource::collection($outlets));
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    public function store(StoreOutletRequest $request) {
        try {
            $outlet = Outlet::create($request->validated());
            return $this->successResponse($outlet, 'Registro realizado exitosamente', 200);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be registered', $exception->getMessage(), 422);
        }
    }

    public function show (Outlet $outlet) {
        try {
            return $this->successResponse(OutletResource::make($outlet), 'Listado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    public function update(StoreOutletRequest $request, Outlet $outlet) {
        try {    
            $outlet->update($request->validated());
            return $this->successResponse($outlet, 'Actualizado exitosamente', 200);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    public function sltOutlets() {
        try {
            $outlets = Outlet::select('id', 'code as name')->get();
            return response()->json($outlets);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }

    public function destroy(Outlet $outlet) {
        try {
            $outlet->delete();
            return $this->successResponse($outlet, 'Eliminado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }

    public function dailyPayrollOutlets($id, $date) {
        try {
            $maxTipoProducto = 4;
            $dailyPayrolls = DailyPayroll::where('id_outlet', $id)
            ->with(['dispatchGuideAnimal' => function ($query) {
                $query->selectRaw('id_daily_payroll, SUM(amount) as total_amount')
                      ->groupBy('id_daily_payroll');
            }])
            ->where(function ($query) use ($maxTipoProducto) {
                $query->whereHas('dispatchGuideAnimal', function ($subquery) use ($maxTipoProducto) {
                    $subquery->selectRaw('id_daily_payroll, SUM(amount) as total_amount')
                             ->groupBy('id_daily_payroll')
                             ->having('total_amount', '<', $maxTipoProducto);
                })->orWhereDoesntHave('dispatchGuideAnimal');
            })
            ->where('sacrifice_date', $date)
            ->get();

            $dailyPayrolls = $dailyPayrolls->map(function($dailyPayroll) {
                $comparison = null;
                $hasInspections = count($dailyPayroll->postmortemInspections) > 0;
                if($hasInspections) {
                    $meetComparison = SeizureComparison::onGetComparison($dailyPayroll->id);
                    $matchedFields  = SeizureComparison::onGetMatches(PostmortemInspections::onGetFieldsToMatch($dailyPayroll->id)); 
                    $comparison['fields'] = $matchedFields;
                    $comparison['success'] = !empty($meetComparison);
                }
                $oResponse['id'] = $dailyPayroll->id;
                $oResponse['code'] = $dailyPayroll->incomeForm->code;
                $oResponse['product_type'] = $dailyPayroll->productType->name;
                $oResponse['special_order'] = $dailyPayroll->special_order;
                $oResponse['comparison'] = $comparison;
                $oResponse['amount'] = $dailyPayroll->productType->amount - $dailyPayroll->dispatchGuideAnimal->sum('total_amount');
                return (object)$oResponse;
            });
            
            $filteredDailyPayrolls = $dailyPayrolls->filter(function ($item) {
                return $item->amount > 0;
            })->values();

            return $this->successResponse($filteredDailyPayrolls);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    
    public function dispatchGuideOutlets($sDate) {
        try {
            $outlets = DailyPayroll::select('id_outlet as id', 'outlets.code as name')
                ->leftJoin('product_types', 'product_types.id', '=', 'daily_payrolls.id_product_type')
                ->leftJoin('outlets', 'outlets.id', '=', 'daily_payrolls.id_outlet')
                ->groupBy('id_outlet')
                ->where('daily_payrolls.sacrifice_date', $sDate)
                ->havingRaw('SUM(product_types.amount) > COALESCE(SUM((SELECT SUM(amount) FROM dispatch_guide_animals WHERE id_daily_payroll = daily_payrolls.id)), 0)')
                ->orderBy('id_outlet')
                ->get();
            return response()->json($outlets);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }
}
