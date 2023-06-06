<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponse;
use App\Http\Resources\PersonResource;

class PersonController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        try {
            $persons = Person::all();
            return response()->json(PersonResource::collection($persons));
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be registered', $exception->getMessage(), 422);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'fullname' => 'required|string|max:255',
                'document' => 'required',
                'expedition_city' => 'required',
            ]);
            
            if($validator->fails()) 
                return response()->json(['message' => 'Field validation failed: '.$validator->errors()->toJson()],400);
        
            $person = Person::create(array_merge($request->all()));

            return response()->json([
                'status' => 'success',
                'message' => 'Registro realizado exitosamente',
                'data' => $person
            ]);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be registered', $exception->getMessage(), 422);
        }
    }

    public function show(Request $request, $id) {
        try {
            $person = Person::find($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Registro listado exitosamente',
                'data' => $person
            ]);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $person = Person::find($id);
            
            if(!$person)
                return response()->json(['message' => 'Person does not found']);
    
            $validator = Validator::make($request->all(), [
                'fullname' => 'required|string|max:255',
                'document' => 'required',
                'expedition_city' => 'required',
            ]);
    
            if($validator->fails()) 
                return response()->json(['message' => 'Field validation failed: '.$validator->errors()->toJson()],400);
    
            $validate_login = Person::where('login', $request->login)
                ->where('id', '!=', $person->id)
                ->first();
            
            if($validate_login) 
                return response()->json(['message' => 'Este login ya se encuentra en uso'], 400);
        
            $person->update([
                'fullname' => $request->fullname,
                'document' => $request->document,
                'adress' => $request->adress,
                'phone' => $request->phone,
            ]);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Registro actualizado exitosamente',
                'data' => $person
            ]);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    public function sltPersons() {
        try {
            $person = Person::select('id', 'fullname as name')->get();
            return response()->json($person);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    public function destroy($id)
    {
        try {
            $person = Person::find($id);
            $person->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Registro eliminado exitosamente',
                'data' => $person
            ]);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }
}
