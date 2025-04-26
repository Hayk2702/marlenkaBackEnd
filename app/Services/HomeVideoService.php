<?php


namespace App\Services;


use App\Models\ContactUs;
use App\Models\HomeSlider;
use App\Models\HomeVideo;
use App\Models\User;
use App\Traits\UploadFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class HomeVideoService
{
    public function show($request){

        if ($request->ajax()) {
            $home = new HomeVideo();

            $home = $home->first();

            return Response::json($home);
        }
        return view('home');

    }

    public function store($request)
    {
        try {
            DB::beginTransaction();
            $home = HomeVideo::first();
            $home->youtube_code = $request->youtube_code;
            $home->save();

            DB::commit();
            return Response::json(['isSuccess' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::json(["message" => $e->getMessage()], 400);
        }
    }

}
