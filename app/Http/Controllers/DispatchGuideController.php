<?php

namespace App\Http\Controllers;

use App\Exports\DispatchGuideExport;
use App\Exports\RetainedProductsExport;
use App\Http\Requests\StoreDispatchGuideRequest;
use App\Http\Requests\UpdateDispatchGuideRequest;
use App\Http\Resources\DispatchGuideResource;
use App\Models\Company;
use App\Models\DailyPayroll;
use App\Models\DispatchGuide;
use App\Models\DispatchGuideAnimal;
use App\Models\InvimaCode;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DispatchGuideController extends Controller
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
            $dispatchGuides = DispatchGuide::all();
            return $this->successResponse(DispatchGuideResource::collection($dispatchGuides));
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
    public function store(StoreDispatchGuideRequest $request)
    {
        try {
            DB::beginTransaction();
            $curDate = Carbon::now();
            $curYear = $curDate->year;
            $invimaCode = InvimaCode::where('year', $curYear)->first();
            $nextCode = DispatchGuide::where('id_invima_code', $invimaCode->id)->max('code') + 1;
            if($nextCode > $invimaCode->codes) 
                return $this->errorResponse('Invalid code', ['El número de guías generada supera las asignadas por el invima'], 400);
 
            $dispatchGuide = DispatchGuide::create(array_merge($request->validated(), [
                'code' => $nextCode, 'id_invima_code' => $invimaCode->id
            ]));

            foreach ($request->animals as $animal) {
                $dailyPayroll = DailyPayroll::find($animal['id']);
                $curDispatchAmount = $dailyPayroll->dispatchGuideAnimal->sum('amount');
                $total = $animal['amount'] + $curDispatchAmount;
                if($total > $dailyPayroll->productType->amount) {
                    DB::rollBack();
                    return $this->errorResponse('Ivalid amount', ['La cantidad registrada para el animal supera el límite asignado al tipo de producto']);
                }
                DispatchGuideAnimal::create(['id_dispatch_guide' => $dispatchGuide->id, 'id_daily_payroll' => $animal['id'], 'amount' => $animal['amount']]);
            }
            DB::commit();
            return $this->successResponse($dispatchGuide, 'Registro realizado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be registered', $exception->getMessage(), 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DispatchGuide  $dispatchGuide
     * @return \Illuminate\Http\Response
     */
    public function show(DispatchGuide $dispatchGuide)
    {
        try {
            return $this->successResponse(DispatchGuideResource::toShow($dispatchGuide), 'Listado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DispatchGuide  $dispatchGuide
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDispatchGuideRequest $request, DispatchGuide $dispatchGuide)
    {
        try {
            $dispatchGuide->update($request->validated());
            return $this->successResponse([], 'Registro realizado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be registered', $exception->getMessage(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DispatchGuide  $dispatchGuide
     * @return \Illuminate\Http\Response
     */
    public function destroy(DispatchGuide $dispatchGuide)
    {
        try {
            $dispatchGuide->delete();
            return $this->successResponse($dispatchGuide, 'Eliminado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }

    public function downloadGuides($id)
    {
        try {
            $dispatchGuide = DispatchGuide::find($id);
            $sacrificeDate = Carbon::parse($dispatchGuide->sacrifice_date);
            $expeditionDate = Carbon::now();
            $closingDate = Carbon::parse($dispatchGuide->closing_date);
            $company = Company::first();
            $config['code'] = $dispatchGuide->invimaCode->invima_code;
            $config['year'] = '-'.substr((string) $dispatchGuide->invimaCode->year, -2);

            $config['sacrifice_date']['day'] = $sacrificeDate->format('d');
            $config['sacrifice_date']['month'] = $sacrificeDate->format('m');
            $config['sacrifice_date']['year'] = $sacrificeDate->format('y');
            $config['sacrifice_date']['complete'] = $sacrificeDate->format('Y-m-d');

            $config['expedition_date']['day'] = $expeditionDate->format('d');
            $config['expedition_date']['month'] = $expeditionDate->format('m');
            $config['expedition_date']['year'] = $expeditionDate->format('y');

            $config['dispatch_time'] = $dispatchGuide->dispatch_time;
            $config['outlet'] = $dispatchGuide->outlet;

            $config['company'] = $company;
            $config['dispatch_guide'] = $dispatchGuide;
            $config['vehicle'] = $dispatchGuide->vehicle;

            $config['closing_date']['day'] = $closingDate->format('d');
            $config['closing_date']['month'] = $closingDate->format('m');
            $config['closing_date']['year'] = $closingDate->format('y');

            $data['products'] = [];
            $data['codes'] = [];

            foreach ($dispatchGuide->dispatchGuideAnimals as $dispatchGuideAnimal) {
                $productTypeId = $dispatchGuideAnimal->dailyPayroll->id_product_type;
                if (!isset($data['products'][$productTypeId])) {
                    $data['products'][$productTypeId] = 0;
                }
                $data['products'][$productTypeId] += $dispatchGuideAnimal->amount;
                $data['codes'][] = $dispatchGuideAnimal->dailyPayroll->incomeForm->code;
            }
            return Excel::download(new DispatchGuideExport(collect($data), $config), 'invoices.xlsx');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    public function downloadRetained($id)
    {
        try {
            $dispatchGuide = DispatchGuide::find($id);
            $sacrificeDate = Carbon::parse($dispatchGuide->sacrifice_date);
            $expeditionDate = Carbon::now();
            $company = Company::first();
            $config['code'] = $dispatchGuide->invimaCode->invima_code;
            $config['year'] = '-'.substr((string) $dispatchGuide->invimaCode->year, -2);

            $config['sacrifice_date']['day'] = $sacrificeDate->format('d');
            $config['sacrifice_date']['month'] = $sacrificeDate->format('m');
            $config['sacrifice_date']['year'] = $sacrificeDate->format('y');
            $config['sacrifice_date']['complete'] = $sacrificeDate->format('Y-m-d');

            $config['expedition_date']['day'] = $expeditionDate->format('d');
            $config['expedition_date']['month'] = $expeditionDate->format('m');
            $config['expedition_date']['year'] = $expeditionDate->format('y');

            $config['dispatch_time'] = $dispatchGuide->dispatch_time;
            $config['outlet'] = $dispatchGuide->outlet;

            $config['company'] = $company;
            $config['dispatch_guide'] = $dispatchGuide;
            $config['vehicle'] = $dispatchGuide->vehicle;

            $data['codes'] = [];
            $dailyPayrolls = DailyPayroll::where(['sacrifice_date' => $dispatchGuide->sacrifice_date, 'id_outlet' => $dispatchGuide->id_outlet])->get();
            foreach ($dailyPayrolls as $dailyPayroll) {
                $data['codes'][] = $dailyPayroll->incomeForm->code;
            }

            return Excel::download(new RetainedProductsExport(collect($data), $config), 'invoices.xlsx');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }
}
