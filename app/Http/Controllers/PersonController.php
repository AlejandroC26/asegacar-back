<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePersonRequest;
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

    public function store(StorePersonRequest $request)
    {
        try {        
            $sSignatureName = '';
            $sAuthorizationName = '';
            if($request->file('signature')) {
                $sSignatureName = 'signature_'.date("Ymd_Hms").'.'.$request->file('signature')->extension();
                $request->file('signature')->storeAs('public/signatures', $sSignatureName);
            }  
            if($request->file('authorization')) {
                $sAuthorizationName = 'authorization_'.date("Ymd_Hms").'.'.$request->file('authorization')->extension();
                $request->file('authorization')->storeAs('public/authorizations', $sAuthorizationName);
            }  
            $person = Person::create(array_merge($request->validated(), [
                'signature' => $sSignatureName,
                'authorization' => $sAuthorizationName
            ]));
            return $this->successResponse($person, 'Registro realizado exitosamente', 200);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be registered', $exception->getMessage(), 422);
        }
    }

    public function show(Person $person) {
        try {
            return $this->successResponse($person, 'Registro listado exitosamente', 200);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    public function update(StorePersonRequest $request, Person $person)
    {
        try {                
            $sSignatureName = $person->signature;
            $sAuthorizationName = $person->authorization;
                        
            if($request->file('signature')) {
                $sSignatureName = $sSignatureName ?? 'signature_'.date("Ymd_Hms").'.'.$request->file('signature')->extension();
                $request->file('signature')->storeAs('public/signatures', $sSignatureName);
            }  

            if($request->file('authorization')) {
                $sAuthorizationName = $sAuthorizationName ?? 'authorization_'.date("Ymd_Hms").'.'.$request->file('authorization')->extension();
                $request->file('authorization')->storeAs('public/authorizations', $sAuthorizationName);
            }  

            $person->update(array_merge($request->validated(), [
                'signature' => $sSignatureName,
                'authorization' => $sAuthorizationName
            ]));
            
            return $this->successResponse($person, 'Registro actualizado exitosamente');
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

    public function destroy(Person $person)
    {
        try {
            $person->delete();
            return $this->successResponse($person, 'Registro eliminado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }

    public function onGetSignature()
    {
        try {

        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }
}
