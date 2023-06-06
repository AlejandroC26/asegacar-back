<?php

namespace App\Http\Controllers;

use App\Helpers\FormatDateHelper;
use App\Http\Resources\ContractResource;
use App\Models\Contracts;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ContractsController extends Controller
{
    use ApiResponse;

    public function index()
    {
        try {
            $contracts = Contracts::all();
            return response()->json(ContractResource::collection($contracts));
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    public function store(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'id_persons' => 'required|max:255',
                'guide_number' => 'required',
                'signature_date' => 'required',
            ]);

            $sNameSignature = '';
            if($request->file('signature')) {
                $sNameSignature = 'signature_'.date("Ymd_Hms").'.'.$request->file('signature')->extension();
                $request->file('signature')->storeAs('public/signature', $sNameSignature);
            }  
                
            if($validator->fails()) 
                return response()->json(['message' => 'Field validation failed: '.$validator->errors()->toJson()],400);
        
            $contract = Contracts::create(array_merge($validator->validated(), [
                'signature' => $sNameSignature
            ]));

            return response()->json([
                'status' => 'success',
                'message' => 'Registro realizado exitosamente',
                'data' => $contract
            ]);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be registered', $exception->getMessage(), 422);
        }
    }

    public function show ($id) {
        try {
            $contract = Contracts::find($id);
            return response()->json([
                'status' => 'success',
                'message' => 'Listado exitosamente',
                'data' => $contract
            ]);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    public function update(Request $request, $id) {
        try {
            $contract = Contracts::find($id);
            
            if(!$contract)
                return response()->json(['message' => 'Does not found']);
    
            $validator = Validator::make($request->all(), [
                'id_persons' => 'required|max:255',
                'guide_number' => 'required',
                'signature_date' => 'required',
            ]);
    
            if($validator->fails()) 
                return response()->json(['message' => 'Field validation failed: '.$validator->errors()->toJson()],400);
            
            $sNameSignature = $contract->signature;
            if($request->file('signature')) {
                $sNameSignature = 'signature_'.date("Ymd_Hms").'.'.$request->file('signature')->extension();
                $request->file('signature')->storeAs('public/signature', $sNameSignature);
            }  
            
            $contract->update(array_merge($validator->validated(), [
                'signature' => $sNameSignature
            ]));
            
            return response()->json([
                'status' => 'success',
                'message' => 'Actualizado exitosamente',
                'data' => $contract
            ]);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    public function destroy($id) {
        try {
            $contract = Contracts::find($id);
            $contract->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Eliminado exitosamente',
                'data' => $contract
            ]);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }

    public function onGetSignature($id) {
        try {
            $contract = Contracts::find($id);
            $sPath = storage_path('app/public/signature/'.$contract->signature);
            $sFileContent = File::get($sPath);
            $sMime = mime_content_type($sPath);
            $sBase64 = base64_encode($sFileContent);
      
            return response()->json(['data' => 'data:' . $sMime . ';base64,' . $sBase64]);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }

    public function generatePDF(Request $request, $id)
    {
        try {
            $contract = Contracts::with('person')->find($id);

            if(!$contract)
                return response()->json(['message' => 'Data was not found'],400);

            $date = Carbon::parse($contract->signature_date);
            
            $sPath = '';
            if($contract->signature)
                $sPath = storage_path('app/public/signature/'.$contract->signature);
                
            $data = [
                "format_code" => $request->format_code,
                'person' => $contract->person->fullname,
                'document' => $contract->person->document,
                'expedition_city' => $contract->person->expedition_city,
                "guide_number" => $contract->guide_number,
                "signature_path" => ($request->hide_signature && $contract->signature) ? false : $sPath,
                "number_days" => $date->format('N'),
                "text_days" => FormatDateHelper::onNumberToLetter($date->format('N')),
                "text_months" => FormatDateHelper::onNumberToMonth(intval($date->format('m'))),
                "month" => ucfirst(FormatDateHelper::onNumberToMonth(intval($date->format('m')))),
                "year" => $date->format('Y'),
                "year_number" => $date->format('y')
            ];

            if($request->hide_date) {
                $data['number_days'] = '___';
                $data['text_days'] = '_____________________';
                $data['text_months'] = '_____________________';
                $data['year_number'] = '____';
            }
            $pdf =  Pdf::loadView('pdf.contract', $data);
            return $pdf->download('Contrato-deposito-animales.pdf');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    
}
