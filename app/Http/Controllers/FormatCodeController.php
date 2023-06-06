<?php

namespace App\Http\Controllers;

use App\Http\Resources\FormatCodeResource;
use App\Models\FormatCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponse;

class FormatCodeController extends Controller
{
    use ApiResponse;

    public function index()
    {
        try {
            $formatCodes = FormatCode::all();
            return response()->json(FormatCodeResource::collection($formatCodes));
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be registered', $exception->getMessage(), 422);
        }
    }

    public function store(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'code' => 'required|max:255',
                'description' => 'required|max:255',
            ]);
            
            if($validator->fails()) 
                return response()->json(['message' => 'Field validation failed: '.$validator->errors()->toJson()],400);
        
            $formatCode = FormatCode::create($validator->validated());
            return $this->successResponse($formatCode, 'Registro realizado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be registered', $exception->getMessage(), 422);
        }
    }

    public function show ($id) {
        try {
            $formatCode = FormatCode::find($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Listado exitosamente',
                'data' => $formatCode
            ]);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    public function update(Request $request, $id) {
        try {
            $formatCode = FormatCode::find($id);
            
            if(!$formatCode)
                return response()->json(['message' => 'Does not found']);
    
            $validator = Validator::make($request->all(), [
                'code' => 'required|max:255',
                'description' => 'required|max:255',
            ]);
    
            if($validator->fails()) 
                return response()->json(['message' => 'Field validation failed: '.$validator->errors()->toJson()],400);
            
            $formatCode->update($validator->validated());
            
            return $this->successResponse($formatCode, 'Actualizado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    public function sltFormatCodes() {
        try {
            $formatCodes = FormatCode::select('id', 'code')->get();
            return response()->json($formatCodes);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }

    public function destroy($id) {
        try {
            $formatCode = FormatCode::find($id);
            $formatCode->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Eliminado exitosamente',
                'data' => $formatCode
            ]);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }
}
