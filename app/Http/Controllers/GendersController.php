<?php

namespace App\Http\Controllers;

use App\Models\Gender;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class GendersController extends Controller
{
    use ApiResponse;
    
    public function index() {
        try {
            $genders = Gender::select('id', 'name')->get();
            return response()->json($genders);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }
}
