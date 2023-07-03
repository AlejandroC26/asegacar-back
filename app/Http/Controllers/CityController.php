<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class CityController extends Controller
{
    use ApiResponse;
    

    public function sltDepartments() {
        try {
            $departments = Department::with('cities')->get();
            return response()->json($departments);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    public function sltCities() {
        try {
            $cities = City::select('id', 'name')->get();
            return response()->json($cities);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }
}
