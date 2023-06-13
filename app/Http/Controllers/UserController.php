<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponse;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        try {
            $users = User::all();
            return response()->json(UserResource::collection($users));
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'fullname' => 'required|string|max:255',
                'document' => 'required',
                'login' => 'required|string|unique:users',
                'password' => 'required|string|min:3',
                'position' => 'required'
            ]);
            
            if($validator->fails()) 
                return response()->json(['message' => 'Field validation failed: '.$validator->errors()->toJson()],400);
        
            $user = User::create(array_merge($request->all(), [
                'password' => Hash::make($request->password),
            ]));

            return response()->json([
                'status' => 'success',
                'message' => 'Registro realizado exitosamente',
                'data' => $user
            ]);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be registered', $exception->getMessage(), 422);
        }
    }

    public function show(Request $request, $id) {
        try {
            $user = User::find($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Usuario listado exitosamente',
                'data' => $user
            ]);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::find($id);
            
            if(!$user)
                return response()->json(['message' => 'User does not found']);
    
            $validator = Validator::make($request->all(), [
                'fullname' => 'required|string|max:255',
                'document' => 'required',
                'login' => 'required|string',
                'position' => 'required'
            ]);
    
            if($validator->fails()) 
                return response()->json(['message' => 'Field validation failed: '.$validator->errors()->toJson()],400);
    
            $validate_login = User::where('login', $request->login)
                ->where('id', '!=', $user->id)
                ->first();
            
            if($validate_login) 
                return response()->json(['message' => 'Este login ya se encuentra en uso'], 400);
        
            $user->update([
                'fullname' => $request->fullname,
                'document' => $request->document,
                'adress' => $request->adress,
                'phone' => $request->phone,
                'login' => $request->login,
                'position' => $request->position
            ]);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Usuario actualizado exitosamente',
                'data' => $user
            ]);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::find($id);
            $user->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Usuario eliminado exitosamente',
                'data' => $user
            ]);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }
}
