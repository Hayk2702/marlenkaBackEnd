<?php

namespace Database\Seeders;

use App\Models\Categories;
use App\Models\ContactUs;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                "phone_number"=>"1-(844)-627-5365",
                "whatsapp"=>"1-(844)-627-5365",
                "email"=>"",
                "facebook_link"=>"",
                "instagram_link"=>"",
                "gmail_link"=>"",
                "linkedin_link"=>"",
                "twitter_link"=>"",
                "youtube_link"=>"",
            ],

        ];
        DB::table('contact_us')->truncate();

        foreach ($data as $val){
            $item = new ContactUs();
            $item->phone_number = $val["phone_number"];
            $item->whatsapp = $val["whatsapp"];
            $item->email = $val["email"];
            $item->facebook_link = $val["facebook_link"];
            $item->instagram_link = $val["instagram_link"];
            $item->gmail_link = $val["gmail_link"];
            $item->linkedin_link = $val["linkedin_link"];
            $item->twitter_link = $val["twitter_link"];
            $item->youtube_link = $val["youtube_link"];
            $item->save();
        }
    }
}
