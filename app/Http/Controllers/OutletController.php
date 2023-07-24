<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOutletRequest;
use App\Http\Resources\OutletResource;
use App\Models\Outlet;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Validator;

class OutletController extends Controller
{
    use ApiResponse;

    public function index()
    {
        try {
            $outlets = Outlet::all();
            return response()->json(OutletResource::collection($outlets));
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
            return $this->successResponse($outlet, 'Listado exitosamente');
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
            $outlets = Outlet::select('id', 'code')->get();
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
}
