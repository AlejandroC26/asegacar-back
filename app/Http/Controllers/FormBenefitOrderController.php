<?php

namespace App\Http\Controllers;

use App\Exports\BenefitOrderExport;
use App\Helpers\FormatDateHelper;
use App\Http\Requests\StoreFormBenefitOrderRequest;
use App\Http\Resources\FormBenefitOrderResource;
use App\Models\FormBenefitOrder;
use App\Models\GeneralParam;
use App\Models\MasterTable;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Builder;


class FormBenefitOrderController extends Controller
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
            $benefitOrder = FormBenefitOrder::all();
            return $this->successResponse(FormBenefitOrderResource::collection($benefitOrder));
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
    public function store(StoreFormBenefitOrderRequest $request)
    {
        try {
            DB::beginTransaction();
            $responsable_id = GeneralParam::onGetResponsable();
            if(!$responsable_id) {
                return $this->errorResponse('The record could not be saved', ['Configura un responsable en la tabla de firmas para continuar'], 409);
            }
            $master = MasterTable::create(['date' => $request->date, 'id_responsable' => $responsable_id, 'id_master_type' => 2]);
            $benefitOrder = FormBenefitOrder::create(array_merge($request->only(['id_daily_payroll']), [
                'id_master' => $master->id
            ]));
            DB::commit();
            return $this->successResponse($benefitOrder, 'Registro realizado exitosamente');
        } catch (\Throwable $exception) {
            DB::rollBack();
            return $this->errorResponse('The record could not be registered', $exception->getMessage(), 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FormBenefitOrder  $formBenefitOrder
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $benefitOrder = FormBenefitOrder::find($id);
            return $this->successResponse(FormBenefitOrderResource::make($benefitOrder), 'Listado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FormBenefitOrder  $formBenefitOrder
     * @return \Illuminate\Http\Response
     */
    public function update(StoreFormBenefitOrderRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $benefitOrder = FormBenefitOrder::findOrFail($id);   
            $benefitOrder->master->update(['date' => $request->date]);
            $benefitOrder->update($request->only(['id_daily_payroll']));
            DB::commit();
            return $this->successResponse($benefitOrder, 'Actualizado exitosamente');
        } catch (\Throwable $exception) {
            DB::rollBack();
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FormBenefitOrder  $formBenefitOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $benefitOrder = FormBenefitOrder::find($id);
            $benefitOrder->delete();
            if(count($benefitOrder->master->benefitOrders) <= 1) {
                $benefitOrder->master->delete();
            }
            DB::commit();
            return $this->successResponse($benefitOrder, 'Eliminado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }

    public function download(Request $request)
    {
        try {
            $benefitOrder = FormBenefitOrder::whereHas('master', function (Builder $query) use ($request) {
                $query->where('date', $request->date);
            })->get();

            if(!count($benefitOrder)) {
                return $this->errorResponse('The report could not be showed', ['There are not records saved']);
            }

            $general['date'] = FormatDateHelper::onGetTextDate($request->date);
            $general['responsable'] = $benefitOrder[0]?->master?->responsable?->fullname;

            return Excel::download(new BenefitOrderExport($benefitOrder, '', '', $general), 'invoices.xlsx');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }
}
