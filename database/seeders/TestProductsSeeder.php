<?php

namespace Database\Seeders;

use App\Models\Categories;
use App\Models\HomeHighlighty;
use App\Models\Product;
use App\Models\ProductImages;
use App\Models\ProductTechnicals;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $data = [
            [
                "name"=>"Classic - Large",
                "description"=>"Our Classic Honey Cake is scrumptious and healthy.",
                "category_id"=>"1",
                "details_one"=>"Let yourself be carried away by the sounds of the Viennese waltz and enjoy this year’s first new product from Marlenka: the Viennese honey Cake. Based on a traditional recipe, we bring you a combination of fluffy honey dough, delicious apricot cream filling and rich cocoa icing.",
                "details_two"=>"This premium cake is perfect for special occasions as well as with your afternoon coffee. You can serve it with whipped cream or pieces of apricots. This combination of two traditional desserts, the classic Viennese cake and Armenian honey cake, is sure to delight you.",
                "details_three"=>"",
                "price"=>25.99,
                "sale_percent"=>0,
                "available_count"=>0,
                "status"=>1,
                "images" =>[
                    "/storage/products/product_1_1.png",
                    "/storage/products/product_1_2.png",
                    "/storage/products/product_1_3.png",
                ],
                "technicals" =>[
                    [
                        "technical" => "Weight",
                        "value" => "1 g",
                    ],
                    [
                        "technical" => "Box dimensions",
                        "value" => "220 x 225 x 50 mm",
                    ],
                    [
                        "technical" => "Package EAN",
                        "value" => "859407165263",
                    ],
                ],
            ],

        ];

        foreach ($data as $val){
            $item = new Product();
            $item->name = $val["name"];
            $item->description = $val["description"];
            $item->category_id = $val["category_id"];
            $item->details_one = $val["details_one"];
            $item->details_two = $val["details_two"];
            $item->details_three = $val["details_three"];
            $item->price = $val["price"];
            $item->sale_percent = $val["sale_percent"];
            $item->available_count = $val["available_count"];
            $item->status = $val["status"];
            $item->save();
            foreach ($val["images"] as $image){
                $productImage = new ProductImages();
                $productImage->product_id = $item->id;
                $productImage->image_path = $image;
                $productImage->save();
            }
            foreach ($val["technicals"] as $technical){
                $productTechnical = new ProductTechnicals();
                $productTechnical->product_id = $item->id;
                $productTechnical->technical = $technical["technical"];
                $productTechnical->value = $technical["value"];
                $productTechnical->save();
            }
            $item->save();
        }
    }
}
