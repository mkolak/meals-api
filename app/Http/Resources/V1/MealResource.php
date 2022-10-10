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
        $status = 'created';
        $diff_time = $request->diff_time;
        if (!is_null($diff_time)) {
            $deleted_at = strtotime($this->deleted_at);
            $updated_at = strtotime($this->updated_at);
            $created_at = strtotime($this->created_at);
            if ($deleted_at > $diff_time) $status = 'deleted';
            else if ($updated_at > $diff_time && $updated_at > $created_at) $status = 'updated';
            else $status = 'created';
        }
        // Base resource
        $resource = [
            'id' => $this->id,
            'title' => $this->translate()->title,
            'description' => $this->translate()->description,
            'status' => $status
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
