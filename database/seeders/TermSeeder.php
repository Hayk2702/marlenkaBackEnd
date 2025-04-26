<?php

namespace Database\Seeders;

use App\Models\Categories;
use App\Models\ContactUs;
use App\Models\PrivacyPolicy;
use App\Models\Term;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                "description"=>"Terms",
            ],

        ];
        DB::table('terms')->truncate();

        foreach ($data as $val){
            $item = new Term();
            $item->description = $val["description"];
            $item->save();
        }
    }
}
