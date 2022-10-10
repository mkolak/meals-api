<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Meal>
 */
class MealFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        static $id = 1;
        $locales = Language::pluck('locale');
        $create = [];
        foreach ($locales as $locale) {
            $create += [$locale => [
                'title' => 'Meal ' . $id . ' ' . $locale,
                'description' => 'Meal ' . $id . ' description, using ' . $locale . ' language'
            ]];
        }
        $categories = Category::pluck('id')->all();
        array_push($categories, null);
        $create += [
            'category_id' => $this->faker->randomElement($categories)
        ];
        $id++;
        return $create;
    }
}
