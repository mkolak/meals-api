<?php

namespace App\Http\Controllers\Api\V1;

use Exception;
use App\Models\Meal;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Services\V1\MealQuery;
use App\Http\Controllers\Controller;
use App\Http\Requests\QueryMealRequest;
use App\Http\Requests\StoreMealRequest;
use App\Http\Resources\V1\MealResource;
use App\Http\Requests\UpdateMealRequest;
use App\Http\Resources\V1\MealCollection;

class MealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(QueryMealRequest $request)
    {
        $meals = new MealQuery();
        $meals = $meals->query($request->validated());

        return new MealCollection($meals);
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
     * @param  \App\Http\Requests\StoreMealRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMealRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Meal  $meal
     * @return \Illuminate\Http\Response
     */
    public function show(Meal $meal)
    {
        return new MealResource($meal);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Meal  $meal
     * @return \Illuminate\Http\Response
     */
    public function edit(Meal $meal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMealRequest  $request
     * @param  \App\Models\Meal  $meal
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMealRequest $request, Meal $meal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Meal  $meal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Meal $meal)
    {
        //
    }
}
