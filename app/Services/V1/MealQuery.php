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

    public function query(Request $request)
    {
        // If diff time is set, just continue querying everything, otherwise, get those that aren't deleted.
        $diff_time = $request->query('diff_time');
        if (!isset($diff_time)) $this->meals = $this->meals->where('status', '!=', 'deleted');

        $category = $request->query('category');
        if (isset($category)) $this->filterByCategory($category);

        $tags = $request->query('tags');
        if (isset($tags)) $this->filterByTags($tags);

        $lang = $request->query('lang');
        if (isset($lang)) App::setLocale($lang);

        $with = $request->query('with');
        if (isset($with)) $this->setRelations($with);

        // If per_page is set, return pagination with that per_page, otherwise, simple paginate() is enough because 
        // query automatically reacts to page parameter
        $per_page = $request->query('per_page');
        if (isset($per_page)) return $this->meals->paginate($per_page);
        else return $this->meals->paginate();
    }

    private function filterByCategory($id)
    {
        if (strtolower($id) == 'null') {
            $this->meals = $this->meals->doesntHave('category');
        } else if (strtolower($id) == '!null') {
            $this->meals = $this->meals->has('category');
        } else {
            $this->meals = ($this->meals)->where('category_id', '=', $id);
        }
    }

    private function filterByTags($tags)
    {
        $tags = array_map('intval', explode(',', $tags));

        foreach ($tags as $tag) {
            $this->meals = $this->meals->whereHas('tags', function ($q) use ($tag) {
                return $q->where('tag_id', $tag);
            });
        }
    }

    private function setRelations($relations)
    {
        $relations = explode(',', $relations);
        $this->meals = $this->meals->with($relations);
    }
}
