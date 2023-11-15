<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGeneralParamsRequest;
use App\Models\GeneralParam;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class GeneralParamsController extends Controller
{
    use ApiResponse;

    public function index() {
        try {
            $response = [];
            foreach (GeneralParam::all() as $value) {
                $response[$value->name] = $value->value;
            }
            return $this->successResponse($response,  'Registro listado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }
    
    public function store(StoreGeneralParamsRequest $request)
    {
        try {
            foreach ($request->validated() as $key => $value) {
               GeneralParam::updateOrCreate(['name' => $key], ['name' => $key, 'value' => $value]);
            }

            return $this->successResponse([], 'Registro realizado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be registered', $exception->getMessage(), 422);
        }
    }
}
