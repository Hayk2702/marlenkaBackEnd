<?php

namespace Database\Seeders;

use App\Models\Categories;
use App\Models\HomeSlider;
use App\Models\HomeVideo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HomeSliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $data = [
            [
                "video_path"=>"",
                "youtube_code"=>"QiwtxINIVn8",
            ]

        ];
        DB::table('home_videos')->truncate();

        foreach ($data as $val){
            $item = new HomeVideo();
            $item->video_path = $val["video_path"];
            $item->youtube_code = $val["youtube_code"];
            $item->save();
        }
    }
}
