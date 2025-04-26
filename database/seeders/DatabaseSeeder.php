<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\HomeHighlighty;
use App\Models\HomeIngredients;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
//            AdminSeeder::class,
//            CategoriesSeeder::class,
//            ContactUsSeeder::class,
//            HomeHighlightiesSeeder::class,
//            HomeIngredientsSeeder::class,
//            HomeRomanticSeeder::class,
//            HomeSliderSeeder::class,
//            HomeVideoSeeder::class,
//            TestProductsSeeder::class,
        PrivacyPolicySeeder::class,
        TermSeeder::class,
        FlavorSeeder::class,
        ]);
    }
}
