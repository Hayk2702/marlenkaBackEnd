<?php

namespace Database\Seeders;

use App\Models\Categories;
use App\Models\ContactUs;
use App\Models\PrivacyPolicy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrivacyPolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                "description"=>"Privacy Policy",
            ],

        ];
        DB::table('privacy_policies')->truncate();

        foreach ($data as $val){
            $item = new PrivacyPolicy();
            $item->description = $val["description"];
            $item->save();
        }
    }
}
