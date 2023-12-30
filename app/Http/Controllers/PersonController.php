<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Traits\ApiResponse;
use App\Http\Requests\StorePersonRequest;
use App\Http\Requests\UpdatePersonsRequest;
use App\Http\Resources\PersonResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PersonController extends Controller
{
    use ApiResponse;

    public function index()
    {
        try {
            $persons = Person::all();
            return $this->successResponse(PersonResource::collection($persons));
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

    public function update(UpdatePersonsRequest $request, Person $person)
    {
        try {                
            $sSignatureName = $person->signature;
            $sAuthorizationName = $person->authorization;
                        
            if($request->file('signature')) {
                $sSignatureName = empty($sSignatureName) ? 'signature_'.date("Ymd_Hms").'.'.$request->file('signature')->extension() : $sSignatureName;
                $request->file('signature')->storeAs('public/signatures', $sSignatureName);
            }  

            if($request->file('authorization')) {
                $sAuthorizationName = empty($sAuthorizationName) ? 'authorization_'.date("Ymd_Hms").'.'.$request->file('authorization')->extension() : $sAuthorizationName;
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

    public function onGetSignature($id)
    {
        try {
            $person = Person::find($id);
            $sPath = storage_path('app/public/signatures/'.$person->signature);
            $sFileContent = File::get($sPath);
            $sMime = mime_content_type($sPath);
            $sBase64 = base64_encode($sFileContent);
            return response()->json(['data' => 'data:' . $sMime . ';base64,' . $sBase64]);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    public function onGetAuthorization($id)
    {
        try {
            $person = Person::find($id);
            $sPath = storage_path('app/public/authorizations/'.$person->authorization);
            return response()->file($sPath);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }
}
