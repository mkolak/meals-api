<?php

namespace Database\Factories;

use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
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
            'slug' => 'cat-' . ($id)
        ];
        foreach ($locales as $locale) {
            $create += [$locale => [
                'title' => 'Category ' . $id . ' ' . $locale
            ]];
        }
        $id++;
        return $create;
    }
}
