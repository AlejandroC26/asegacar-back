<?php

namespace App\Http\Controllers;

use App\Exports\DailyRoutesExport;
use App\Http\Requests\StoreDailyRouteRequest;
use App\Http\Resources\DailyRouteResource;
use App\Models\DailyRoutes;
use App\Traits\ApiResponse;
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
            $routes = DailyRoutes::with('route', 'antemortem_daily_record.outlet')->get();
            return response()->json(DailyRouteResource::collection($routes));
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
    public function show($id)
    {
        try {
            $route = DailyRoutes::find($id);
            return $this->successResponse(DailyRouteResource::make($route), 'Listado exitosamente');
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
            $dailyRoutes = DailyRoutes::with('route', 'antemortem_daily_record.outlet')
                ->where('date', $request->date)->get();
            $response = [];
            foreach ($dailyRoutes as $route) {
                if(!array_key_exists($route->route->name, $response)) {
                    // $temporal['outlet'];
                    // $temporal['animal'];

                    $response[$route->route->name]['route'] = $route->route->name;
                    $response[$route->route->name]['data'][] = $route;
                } 
            }

            // return $dailyRoutes;
            return $response;
            return Excel::download(new DailyRoutesExport([], '', '', ''), 'invoices.xlsx');
        } catch (\Throwable $exception) {
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }
}
