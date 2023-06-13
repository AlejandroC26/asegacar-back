<?php

namespace App\Http\Controllers;

use App\Http\Resources\ZeroGutsToleranceResource;
use App\Models\ZeroGutsTolerance;
use Illuminate\Http\Request;

class ZeroGutsToleranceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $inspections = ZeroGutsTolerance::all();
            return response()->json(ZeroGutsToleranceResource::collection($inspections));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ZeroGutsTolerance  $zeroGutsTolerance
     * @return \Illuminate\Http\Response
     */
    public function show(ZeroGutsTolerance $zeroGutsTolerance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ZeroGutsTolerance  $zeroGutsTolerance
     * @return \Illuminate\Http\Response
     */
    public function edit(ZeroGutsTolerance $zeroGutsTolerance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ZeroGutsTolerance  $zeroGutsTolerance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ZeroGutsTolerance $zeroGutsTolerance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ZeroGutsTolerance  $zeroGutsTolerance
     * @return \Illuminate\Http\Response
     */
    public function destroy(ZeroGutsTolerance $zeroGutsTolerance)
    {
        //
    }
}
