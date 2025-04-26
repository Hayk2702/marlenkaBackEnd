<?php


namespace App\Services;


use App\Models\ContactUs;
use App\Models\HomeHighlighty;
use App\Models\HomeSlider;
use App\Models\User;
use App\Traits\UploadFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class HomeHighlightiesService
{
    use UploadFile;

    public function show($request){

        if ($request->ajax()) {
            $home = new HomeHighlighty();

            $home = $home->first();

            return Response::json($home);
        }
        return view('home');

    }

    public function store($request)
    {
        try {
            DB::beginTransaction();
            $home = HomeHighlighty::first();
            if ($request->hasFile('image_path')) {
                $image_path = $home->image_path ?? null;
                $image = $request->file('image_path');
                $home->image_path = $this->upload($image, "highlighties", $image_path);
            }

            $home->title = $request->title;
            $home->description_one = $request->description_one;
            $home->description_two = $request->description_two;
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
