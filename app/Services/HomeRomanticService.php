<?php


namespace App\Services;


use App\Models\ContactUs;
use App\Models\HomeRomantic;
use App\Models\HomeSlider;
use App\Models\User;
use App\Traits\UploadFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class HomeRomanticService
{
    use UploadFile;

    public function show($request){

        if ($request->ajax()) {
            $home = new HomeRomantic();

            $home = $home->first();

            return Response::json($home);
        }
        return view('home');

    }

    public function store($request)
    {
        try {
            DB::beginTransaction();
            $home = HomeRomantic::first();

            if ($request->hasFile('image_path')) {
                $image_path = $home->image_path ?? null;
                $image = $request->file('image_path');
                $home->image_path = $this->upload($image, "romantics", $image_path);
            }
            if ($request->hasFile('image_path_two')) {
                $image_path_two = $home->image_path_two ?? null;
                $image = $request->file('image_path_two');
                $home->image_path_two = $this->upload($image, "romantics", $image_path_two);
            }
            if ($request->hasFile('image_path_three')) {
                $image_path_three = $home->image_path_three ?? null;
                $image = $request->file('image_path_three');
                $home->image_path_three = $this->upload($image, "romantics", $image_path_three);
            }
            if ($request->hasFile('small_image_path')) {
                $image_path = $home->small_image_path ?? null;
                $image = $request->file('small_image_path');
                $home->small_image_path = $this->upload($image, "romantics", $image_path);
            }

            $home->title_one = $request->title_one;
            $home->description_one = $request->description_one;
            $home->title_two = $request->title_two;
            $home->description_two = $request->description_two;
            $home->title_three = $request->title_three;
            $home->description_three = $request->description_three;
            $home->save();

            DB::commit();
            return Response::json(['isSuccess' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::json(["message" => $e->getMessage()], 400);
        }
    }

}
