<?php

namespace Database\Seeders;

use App\Models\Categories;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {






        $data = [
            [
                "name"=>"Cakes",
                "description"=>"",
                "image_path"=>""
            ],
            [
                "name"=>"Rolls",
                "description"=>"",
                "image_path"=>""
            ],
            [
                "name"=>"Eclairs",
                "description"=>"",
                "image_path"=>""
            ],
            [
                "name"=>"Napoleons",
                "description"=>"",
                "image_path"=>""
            ],
            [
                "name"=>"Snacks",
                "description"=>"",
                "image_path"=>""
            ],
            [
                "name"=>"Nuggets",
                "description"=>"",
                "image_path"=>""
            ],
            [
                "name"=>"Specials",
                "description"=>"",
                "image_path"=>""
            ],
        ];
        DB::table('categories')->truncate();

        foreach ($data as $val){
            $item = new Categories();
            $item->name = $val["name"];
            $item->save();
        }
    }
}
