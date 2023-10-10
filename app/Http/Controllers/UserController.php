<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponse;
use App\Http\Resources\UserResource;
use App\Models\Charge;
use App\Models\Person;

class UserController extends Controller
{
    use ApiResponse;

    // public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }

    public function index()
    {
        try {
            $users = User::all();
            return response()->json(UserResource::collection($users));
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    public function store(StoreUserRequest $request)
    {
        try {        
            $user = User::create(array_merge($request->all(), [
                'password' => Hash::make($request->password),
            ]));

            return $this->successResponse($user, 'Registro realizado exitosamente');
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

    public function update(UpdateUserRequest $request, User $user)
    {
        try {                
            $validate_login = User::where('login', $request->login)->where('id', '!=', $user->id)->first();

            if($validate_login) 
                return response()->json(['message' => 'Este login ya se encuentra en uso'], 400);

            $user->update($request->validated());
            
            return $this->successResponse($user, 'Usuario actualizado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
            return $this->successResponse($user, 'Registro eliminado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }

    public function sltUsers()
    {
        try {
            $users = User::select('users.id', 'persons.fullname as name')
                ->join('persons', 'persons.id', 'users.id_person')
                ->get();
            return response()->json($users);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }

    public function sltCharges()
    {
        try {
            $charges = Charge::select('id', 'name')->get();
            return response()->json($charges);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }
}
