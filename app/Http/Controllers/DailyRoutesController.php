<?php

namespace App\Http\Controllers;

use App\Exports\DailyRoutesExport;
use App\Http\Requests\StoreDailyRouteRequest;
use App\Http\Resources\DailyRouteResource;
use App\Models\DailyRoutes;
use App\Models\Route;
use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class DailyRoutesController extends Controller
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
            $routes = DailyRoutes::with('route')->get();
            return $this->successResponse(DailyRouteResource::collection($routes));
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDailyRouteRequest $request)
    {
        try {
            $route = DailyRoutes::create($request->validated());
            return $this->successResponse($route, 'Registro realizado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be registered', $exception->getMessage(), 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DailyRoutes  $dailyRoutes
     * @return \Illuminate\Http\Response
     */
    public function show(DailyRoutes $dailyRoute)
    {
        try {
            return $this->successResponse(DailyRouteResource::make($dailyRoute), 'Listado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DailyRoutes  $dailyRoutes
     * @return \Illuminate\Http\Response
     */
    public function update(StoreDailyRouteRequest $request, $id)
    {
        try {
            $route = DailyRoutes::findOrFail($id);        
            $route->update($request->validated());
            return $this->successResponse($route, 'Actualizado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DailyRoutes  $dailyRoutes
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $route = DailyRoutes::find($id);
            $route->delete();
            return $this->successResponse($route, 'Eliminado exitosamente');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }

    public function download(Request $request)
    {
        try {

            $routes = Route::whereHas('dailyRoutes', function(Builder $query) use ($request) {
                $query->where('date', $request->date);
            })->with(['dailyRoutes' => function($query) use ($request) {
                $query->where('date', $request->date);
            }])->orderBy('id')->get();

            if(!count($routes)) {
                return $this->errorResponse('The report could not be showed', ['There are not records saved']);
            }
            return Excel::download(new DailyRoutesExport($routes, $request->date), 'invoices.xlsx');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }
}
