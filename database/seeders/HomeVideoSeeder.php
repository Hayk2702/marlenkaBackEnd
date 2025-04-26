<?php

namespace Database\Seeders;

use App\Models\Categories;
use App\Models\HomeSlider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HomeVideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $data = [
            [
                "title"=>"",
                "description"=>"Marlenka Eclairs offers an original culinary experience in a mini dessert based on choux pastry with delicious milky cream filling.",
                "product_id"=>"1",
                "image_path"=>"/storage/sliders/slider1.png",
                "small_image_path"=>"/storage/sliders/small_slider1.png",
            ],
            [
                "title"=>"",
                "description"=>"Marlenka Eclairs offers an original culinary experience in a mini dessert based on choux pastry with delicious milky cream filling.",
                "product_id"=>"1",
                "image_path"=>"/storage/sliders/slider1.png",
                "small_image_path"=>"/storage/sliders/small_slider1.png",
            ],

        ];
        DB::table('home_sliders')->truncate();

        foreach ($data as $val){
            $item = new HomeSlider();
            $item->title = $val["title"];
            $item->description = $val["description"];
            $item->product_id = $val["product_id"];
            $item->image_path = $val["image_path"];
            $item->small_image_path = $val["small_image_path"];
            $item->save();
        }
    }
}
