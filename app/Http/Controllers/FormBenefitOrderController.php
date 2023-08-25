<?php

namespace App\Http\Controllers;

use App\Exports\BenefitOrderExport;
use App\Http\Requests\StoreFormBenefitOrderRequest;
use App\Http\Resources\FormBenefitOrderResource;
use App\Http\Resources\StoreFormBenefitOrder;
use App\Models\FormBenefitOrder;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
            return response()->json(FormBenefitOrderResource::collection($benefitOrder));
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            $benefitOrder = FormBenefitOrder::create($request->validated());
            return $this->successResponse($benefitOrder, 'Registro realizado exitosamente');
        } catch (\Throwable $exception) {
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FormBenefitOrder  $formBenefitOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(FormBenefitOrder $formBenefitOrder)
    {
        //
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
            $benefitOrder = FormBenefitOrder::findOrFail($id);        
            $benefitOrder->update($request->validated());
            return $this->successResponse($benefitOrder, 'Actualizado exitosamente');
        } catch (\Throwable $exception) {
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
            $benefitOrder = FormBenefitOrder::find($id);
            $benefitOrder->delete();
            return $this->successResponse($benefitOrder, 'Eliminado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }

    public function download(Request $request)
    {
        try {
            $benefitOrder = FormBenefitOrder::where('id_master', $request->id_master)->get();
            return Excel::download(new BenefitOrderExport($benefitOrder, '', '', ''), 'invoices.xlsx');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }
}
