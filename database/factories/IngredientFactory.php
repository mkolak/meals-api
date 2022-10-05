<?php

namespace Database\Factories;

use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ingredient>
 */
class IngredientFactory extends Factory
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
        $create = [
            'slug' => 'ingr-' . ($id)
        ];
        foreach ($locales as $locale) {
            $create += [$locale => [
                'title' => 'Ingredient ' . $id . ' ' . $locale
            ]];
        }
        $id++;
        return $create;
    }
}
