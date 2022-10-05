<?php

namespace App\Http\Resources\V1;

use App\Models\Meal;
use App\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;

class MealResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // Base resource
        $resource = [
            'id' => $this->id,
            'title' => $this->translate()->title,
            'description' => $this->translate()->description,
            'status' => $this->status
        ];

        // Extending the resource, depending on "when" parameter of query
        $relations = array_keys($this->relationsToArray());
        foreach ($relations as $relation) {
            if ($relation == 'category') {
                $resource += [
                    'category' => new CategoryResource($this->category)
                ];
            } else if ($relation == 'tags') {
                $resource += [
                    'tags' => new TagCollection($this->tags)
                ];
            } else if ($relation == 'ingredients') {
                $resource += [
                    'ingredients' => new IngredientCollection($this->ingredients)
                ];
            }
        }

        return $resource;
    }
}
