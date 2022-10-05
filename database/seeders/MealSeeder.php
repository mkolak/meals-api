<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\Meal;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Meal::factory()->count(350)->create();

        // Maximum number of tags each meal has is 3 by default.
        // You can increase number of tags by changing value X in "take(rand(1, X ))"
        foreach (Meal::all() as $meal) {
            $tags = Tag::all()->shuffle()->take(rand(1, 3));
            $meal->tags()->attach($tags);
        }

        // Maximum number of ingredients each meal has is 3 by default.
        // You can increase number of ingredients by changing value X in "take(rand(1, X ))"
        foreach (Meal::all() as $meal) {
            $ingredients = Ingredient::all()->shuffle()->take(rand(1, 3));
            $meal->ingredients()->attach($ingredients);
        }
    }
}
