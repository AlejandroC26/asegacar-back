<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGuideRequest;
use App\Http\Resources\GuideResource;
use App\Models\Guide;
use App\Models\Specie;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class GuideController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $guides = Guide::all();
            return $this->successResponse(GuideResource::collection($guides));
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGuideRequest $request)
    {
        try {
            $sFileName = '';
            if($request->file('file_attached')) {
                $sFileName = 'guide'.date("Ymd_Hms").'.'.$request->file('file_attached')->extension();
                $request->file('file_attached')->storeAs('public/guide', $sFileName);
            }  
            $guide = Guide::create(array_merge($request->validated(), ['file_attached' => $sFileName]));
            return $this->successResponse($guide, 'Registro realizado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be registered', $exception->getMessage(), 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Guide $guide)
    {
        try {
            return $this->successResponse(GuideResource::make($guide), 'Listado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreGuideRequest $request, Guide $guide)
    {
        try {   
            $sFileName = $guide->file_attached;
            if($request->file('file_attached')) {
                $sFileName = $sFileName || 'guide'.date("Ymd_Hms").'.'.$request->file('file_attached')->extension();
                $request->file('file_attached')->storeAs('public/guide', $sFileName);
            }  
            $guide->update(array_merge($request->validated(), ['file_attached' => $sFileName]));
            return $this->successResponse($guide, 'Actualizado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Guide $guide)
    {
        try {
            $guide->delete();
            return $this->successResponse($guide, 'Eliminado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }

    public function sltGuides () {
        try {
            $guides = Guide::select('id', 'code as name')->get();
            return response()->json($guides);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    public function sltSpecies () {
        try {
            $guides = Specie::select('id', 'name')->get();
            return response()->json($guides);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    public function downloadGuide($id) {
        try {
            $oGuide = Guide::find($id);
            if(!$oGuide->file_attached) {
                return $this->errorResponse("File doesnt't found", ["The file does not found"]);
            }
            $sPath = storage_path('app/public/guide/'.$oGuide->file_attached);
            $headers = [ 'Content-Type' => 'application/pdf' ];
            return response()->download($sPath, 'guide.pdf', $headers);
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    public function generatePDF($id)
    {
        try {
            $guide = Guide::find($id);
            $data['person'] = $guide->owner;
            $data['guide'] = $guide->code;
            $pdf =  Pdf::loadView('pdf.contract', $data);
            return $pdf->download('Contrato-deposito-animales.pdf');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }
}
