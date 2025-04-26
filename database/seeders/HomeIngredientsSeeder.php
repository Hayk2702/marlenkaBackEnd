<?php

namespace Database\Seeders;

use App\Models\Categories;
use App\Models\HomeHighlighty;
use App\Models\HomeIngredients;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HomeIngredientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $data = [
            [
                "title"=>"CONDENSED MILK",
                "description"=>"Our Classic Honey Cake is scrumptious and healthy.",
                "image_path"=>"/storage/ingredients/category1.png",
            ],
            [
                "title"=>"NATURAL HONEY",
                "description"=>"Our Classic Honey Cake is scrumptious and healthy.",
                "image_path"=>"/storage/ingredients/category2.png",
            ],
            [
                "title"=>"WALNUT",
                "description"=>"Our Classic Honey Cake is scrumptious and healthy.",
                "image_path"=>"/storage/ingredients/category3.png",
            ],
            [
                "title"=>"Apricot",
                "description"=>"Our Classic Honey Cake is scrumptious and healthy.",
                "image_path"=>"/storage/ingredients/category4.png",
            ],
            [
                "title"=>"Almond",
                "description"=>"Our Classic Honey Cake is scrumptious and healthy.",
                "image_path"=>"/storage/ingredients/category5.png",
            ],
            [
                "title"=>"Coffee",
                "description"=>"Our Classic Honey Cake is scrumptious and healthy.",
                "image_path"=>"/storage/ingredients/category6.png",
            ],
            [
                "title"=>"Cocoa",
                "description"=>"Our Classic Honey Cake is scrumptious and healthy.",
                "image_path"=>"/storage/ingredients/category7.png",
            ],

        ];
        DB::table('home_ingredients')->truncate();

        foreach ($data as $val){
            $item = new HomeIngredients();
            $item->title = $val["title"];
            $item->description = $val["description"];
            $item->image_path = $val["image_path"];
            $item->save();
        }
    }
}
