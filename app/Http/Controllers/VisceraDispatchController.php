<?php

namespace App\Http\Controllers;

use App\Exports\VisceraDispatchExport;
use App\Helpers\FormatDateHelper;
use App\Http\Requests\StoreVisceraDispatchRequest;
use App\Http\Resources\VisceraDispatchResource;
use App\Models\GeneralParam;
use App\Models\MasterTable;
use App\Models\VisceraDispatch;
use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class VisceraDispatchController extends Controller
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
            $visceraDispatch = VisceraDispatch::all();
            return $this->successResponse(VisceraDispatchResource::collection($visceraDispatch));
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVisceraDispatchRequest $request)
    {
        try {
            $errors = [];

            $id_supervised_by = GeneralParam::onGetSupervisedBy();
            $id_elaborated_by = GeneralParam::onGetElaboratedBy();

            if(!$id_supervised_by)
                $errors[] = 'Configura a la persona que supervisa en la tabla de firmas para continuar';
            if(!$id_elaborated_by)
                $errors[] = 'Configura a la persona que elabora en la tabla de firmas para continuar';
            
            if(count($errors)) 
                return $this->errorResponse('The record could not be saved', $errors, 409);

            $master = MasterTable::create(['date' => $request->date, 
                'id_supervised_by' => $id_supervised_by,
                'id_elaborated_by' => $id_elaborated_by,
                'id_specie' => $request->id_specie,
                'id_master_type' => 7,
            ]);

            $visceraDispatch = VisceraDispatch::create(array_merge($request->validated(), ['id_master' => $master->id]));
            return $this->successResponse($visceraDispatch, 'Registro realizado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be registered', $exception->getMessage(), 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VisceraDispatch  $visceraDispatch
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $visceraDispatch = VisceraDispatch::find($id);
            return $this->successResponse(VisceraDispatchResource::make($visceraDispatch), 'Listado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VisceraDispatch  $visceraDispatch
     * @return \Illuminate\Http\Response
     */
    public function update(StoreVisceraDispatchRequest $request, $id)
    {
        try {
            $visceraDispatch = VisceraDispatch::findOrFail($id);      
            $visceraDispatch->master->update(['date' => $request->date]); 
            $visceraDispatch->update($request->validated());
            return $this->successResponse($visceraDispatch, 'Actualizado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VisceraDispatch  $visceraDispatch
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $visceraDispatch = VisceraDispatch::find($id);
            $visceraDispatch->delete();
            if(count($visceraDispatch->master->visceraDispatches) <= 1) {
                $visceraDispatch->master->delete();
            }
            return $this->successResponse($visceraDispatch, 'Eliminado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }

    public function download(Request $request)
    {
        try {
            $visceraDispatch = VisceraDispatch::whereHas('master', function (Builder $query) use ($request) {
                $query->where('date', $request->date);
            })->get();
            $visceraDispatch = VisceraDispatchResource::collection($visceraDispatch);

            if(!count($visceraDispatch)) {
                return $this->errorResponse('The report could not be showed', ['There are not records saved']);
            }

            $general['date'] = FormatDateHelper::onGetTextDate($request->date);
            $general['supervised_by'] = $visceraDispatch[0]?->master->supervised_by->fullname;
            $general['elaborated_by'] = $visceraDispatch[0]?->master->elaborated_by->fullname;

            return Excel::download(new VisceraDispatchExport($visceraDispatch, $general), 'invoices.xlsx');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }
}
