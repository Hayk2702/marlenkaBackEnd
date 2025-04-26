<?php

namespace Database\Seeders;

use App\Models\Categories;
use App\Models\HomeHighlighty;
use App\Models\HomeRomantic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HomeRomanticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $data = [
            [
                "image_path"=>"/storage/romantic/home2.png",
                "small_image_path"=>"/storage/romantic/home3.png",
                "title_one"=>"Romantic gift",
                "description_one"=>"Show your love in the most delicious way possible. Real jewels of taste in splendid boxes, our chocolates will make your better half melt.",
                "title_two"=>"Birthday gift",
                "description_two"=>"A birthday! A cake, candles… All you need now is your Leonidas surprise! Give your loved one a special surprise: offer him or her their favourite chocolates or a varied assortment.",
                "title_three"=>"Invitation",
                "description_three"=>"Show how happy you are to receive your invitation: offer the hosts the creations of our Maîtres Chocolatiers to express your thanks. There's nothing like it to put a smile on their lips.",
            ],

        ];
        DB::table('home_romantics')->truncate();

        foreach ($data as $val){
            $item = new HomeRomantic();
            $item->image_path = $val["image_path"];
            $item->small_image_path = $val["small_image_path"];
            $item->title_one = $val["title_one"];
            $item->description_one = $val["description_one"];
            $item->title_two = $val["title_two"];
            $item->description_two = $val["description_two"];
            $item->title_three = $val["title_three"];
            $item->description_three = $val["description_three"];
            $item->save();
        }
    }
}
