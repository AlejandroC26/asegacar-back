<?php

namespace App\Http\Controllers;

use App\Models\Purpose;
use Illuminate\Http\Request;
use App\Http\Resources\PurposeResource;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponse;

class PurposeController extends Controller
{
    use ApiResponse;
    
    public function index()
    {
        try {
            $purposes = Purpose::all();
            return response()->json(PurposeResource::collection($purposes));
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be registered', $exception->getMessage(), 422);
        }
    }

    public function store(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
            ]);
            
            if($validator->fails()) 
                return response()->json(['message' => 'Field validation failed: '.$validator->errors()->toJson()],400);
        
            $purpose = Purpose::create([
                "name" => $request->name
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Registro realizado exitosamente',
                'data' => $purpose
            ]);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be registered', $exception->getMessage(), 422);
        }
    }

    public function show ($id) {
        try {
            $purpose = Purpose::find($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Usuario listado exitosamente',
                'data' => $purpose
            ]);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    public function update(Request $request, $id) {
        try {
            $purpose = Purpose::find($id);
            
            if(!$purpose)
                return response()->json(['message' => 'User does not found']);
    
            $validator = Validator::make($request->all(), [
                'name' => 'name|max:255',
            ]);
    
            if($validator->fails()) 
                return response()->json(['message' => 'Field validation failed: '.$validator->errors()->toJson()],400);
            
            $purpose->update([
                'name' => $request->name
            ]);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Actualizado exitosamente',
                'data' => $purpose
            ]);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    public function sltPurposes() {
        try {
            $purposes = Purpose::select('id', 'name')->get();
            return response()->json($purposes);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }

    public function destroy($id) {
        try {
            $purpose = Purpose::find($id);
            $purpose->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Usuario eliminado exitosamente',
                'data' => $purpose
            ]);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }
}
