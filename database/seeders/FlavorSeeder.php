<?php

namespace Database\Seeders;

use App\Models\Categories;
use App\Models\ContactUs;
use App\Models\Flavor;
use App\Models\PrivacyPolicy;
use App\Models\Term;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FlavorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                "name"=>"Classic",
            ],
            [
                "name"=>"Walnut",
            ],
            [
                "name"=>"Cocoa",
            ],
            [
                "name"=>"Cinnamon",
            ],
            [
                "name"=>"Lemon",
            ],
            [
                "name"=>"Apricot",
            ],
            [
                "name"=>"Gluten Free",
            ],

        ];
        DB::table('flavors')->truncate();

        foreach ($data as $val){
            $item = new Flavor();
            $item->name = $val["name"];
            $item->save();
        }
    }
}
