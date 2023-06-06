<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ColorsController extends Controller
{
    use ApiResponse;
    public function index() {
        try {
            $colors = Color::select('id', 'name')->get();
            return response()->json($colors);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }
}
