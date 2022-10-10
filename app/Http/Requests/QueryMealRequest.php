<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

class QueryMealRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'category' => 'nullable|in:' . Category::implode('id', ',') . ",null,!null",
            'page' => 'nullable',
            'per_page' => 'nullable',
            'diff_time' => 'nullable|gt:0',
            'tags' => 'nullable|array',
            'with' => 'nullable|array',
            'with.*' => 'in:category,tags,ingredients',
            'tags.*' => 'exists:tags,id',
            'lang' => 'required|exists:languages,locale'
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->category) $this->merge([
            'category' => strtolower($this->category)
        ]);

        if ($this->with) $this->merge([
            'with' => explode(',', $this->with)
        ]);

        if ($this->tags) $this->merge([
            'tags' => explode(',', $this->tags)
        ]);
    }

    protected $stopOnFirstFailure = true;
}
