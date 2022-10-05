<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Meal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMealRequest;
use App\Http\Resources\V1\MealResource;
use App\Http\Requests\UpdateMealRequest;
use App\Http\Resources\V1\MealCollection;
use App\Models\Language;
use App\Services\V1\MealQuery;
use App\Services\V1\MealQueryValidator;
use Exception;

class MealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            MealQueryValidator::validate($request);
        } catch (Exception $e) {
            return response(['error' => true, 'error-msg' => $e->getMessage()], 404);
        }

        $meals = new MealQuery();
        $meals = $meals->query($request);

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
