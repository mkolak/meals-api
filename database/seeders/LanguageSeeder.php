<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locales = ['en', 'hr', 'fr'];
        foreach ($locales as $locale) {
            Language::factory()->withLocale($locale)->create();
        }
    }
}
