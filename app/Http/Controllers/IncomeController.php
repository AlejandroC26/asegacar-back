<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIncomeRequest;
use App\Http\Resources\IncomeResource;
use App\Models\Income;
use App\Traits\ApiResponse;

class IncomeController extends Controller
{
    use ApiResponse;

    public function index()
    {
        try {
            $incomes = Income::all();
            return response()->json(IncomeResource::collection($incomes));
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    public function store(StoreIncomeRequest $request) {
        try {            
            $income = Income::create($request->validated());

            return response()->json([
                'status' => 'success',
                'message' => 'Registro realizado exitosamente',
                'data' => $income
            ]);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be registered', $exception->getMessage(), 422);
        }
    }

    public function show ($id) {
        try {
            $income = Income::find($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Usuario listado exitosamente',
                'data' => $income
            ]);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    public function update(StoreIncomeRequest $request, $id) {
        try {
            $income = Income::find($id);
            
            if(!$income)
                return response()->json(['message' => 'Does not found']);
            
            $income->update($request->validated());
            
            return response()->json([
                'status' => 'success',
                'message' => 'Actualizado exitosamente',
                'data' => $income
            ]);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    public function destroy($id) {
        try {
            $income = Income::find($id);
            $income->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Usuario eliminado exitosamente',
                'data' => $income
            ]);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }
}
