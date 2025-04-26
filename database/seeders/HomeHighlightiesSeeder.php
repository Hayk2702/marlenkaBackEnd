<?php

namespace Database\Seeders;

use App\Models\Categories;
use App\Models\HomeHighlighty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HomeHighlightiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $data = [
            [
                "title"=>"SWEET HIGHLIGHT",
                "description_one"=>"International success has enabled export to more than 40 countries worldwide, while achieving top marks verified by Quality Food Certificates!",
                "description_two"=>"No artificial colors or preservatives are ever used. All of our products are free from alcohol, animal fat, and genetically modified ingredients. Gluten-free options are also widely available.",
                "description_three"=>"Full range has been developed with the extremely long ambient shelf-life due to our unique vacuum and O2 absorbent packaging technology. Unique taste and universal appeal of our product line is complemented with rich flavors and soft consistency.",
                "image_path"=>"/storage/highlighties/highlight1.png",
            ],

        ];
        DB::table('home_highlighties')->truncate();

        foreach ($data as $val){
            $item = new HomeHighlighty();
            $item->title = $val["title"];
            $item->description_one = $val["description_one"];
            $item->description_two = $val["description_two"];
            $item->description_three = $val["description_three"];
            $item->image_path = $val["image_path"];
            $item->save();
        }
    }
}
