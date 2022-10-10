<?php

namespace App\Services\V1;

use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class MealQuery
{
    protected $meals;

    public function __construct()
    {
        $this->meals = Meal::query();
    }

    public function query($request)
    {
        if (array_key_exists('diff_time', $request)) $this->filterByDiffTime($request['diff_time']);

        if (array_key_exists('category', $request)) $this->filterByCategory($request['category']);

        if (array_key_exists('tags', $request)) $this->filterByTags($request['tags']);

        if (array_key_exists('lang', $request)) App::setLocale($request['lang']);

        if (array_key_exists('with', $request)) $this->setRelations($request['with']);

        // if (array_key_exists('with', $request)) $this->setRelations($request['with']);
        // If per_page is set, return pagination with that per_page, otherwise, simple paginate() is enough because 
        // query automatically reacts to page parameter
        if (array_key_exists('per_page', $request)) return $this->meals->paginate($request['per_page']);
        else return $this->meals->paginate();
    }

    private function filterByCategory($id)
    {
        if (strtolower($id) == 'null') {
            $this->meals = $this->meals->doesntHave('category');
        } else if (strtolower($id) == '!null') {
            $this->meals = $this->meals->has('category');
        } else {
            $this->meals = ($this->meals)->where('category_id', '=', intval($id));
        }
    }

    private function filterByTags($tags)
    {
        foreach ($tags as $tag) {
            $this->meals = $this->meals->whereHas('tags', function ($q) use ($tag) {
                return $q->where('tag_id', $tag);
            });
        }
    }

    private function setRelations($relations)
    {
        $this->meals = $this->meals->with($relations);
    }

    private function filterByDiffTime($diff_time)
    {
        $this->meals = $this->meals->withTrashed()->where(function ($query) use ($diff_time) {
            $query->where('created_at', '>', $diff_time)->orWhere('updated_at', '>', $diff_time)->orWhere('deleted_at', '>', $diff_time);
        });
    }
}
