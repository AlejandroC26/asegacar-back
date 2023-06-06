<?php

namespace App\Http\Controllers;

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

    public function store(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'description' => 'required|max:255',
            ]);
            
            if($validator->fails()) 
                return response()->json(['message' => 'Field validation failed: '.$validator->errors()->toJson()],400);
        
            $outlet = Outlet::create([
                "description" => $request->description
            ]);

            return $this->successResponse($outlet, 'Registro realizado exitosamente', 200);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be registered', $exception->getMessage(), 422);
        }
    }

    public function show ($id) {
        try {
            $outlet = Outlet::find($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Usuario listado exitosamente',
                'data' => $outlet
            ]);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    public function update(Request $request, $id) {
        try {
            $outlet = Outlet::find($id);
            
            if(!$outlet)
                return response()->json(['message' => 'User does not found']);
    
            $validator = Validator::make($request->all(), [
                'description' => 'required|max:255',
            ]);
    
            if($validator->fails()) 
                return response()->json(['message' => 'Field validation failed: '.$validator->errors()->toJson()],400);
            
            $outlet->update([
                'description' => $request->description
            ]);

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

    public function destroy($id) {
        try {
            $outlet = Outlet::find($id);
            $outlet->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Usuario eliminado exitosamente',
                'data' => $outlet
            ]);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }
}
