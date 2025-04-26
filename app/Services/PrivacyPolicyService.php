<?php


namespace App\Services;


use App\Models\AboutUsData;
use App\Models\Award;
use App\Models\ContactUs;
use App\Models\FAQ;
use App\Models\HomeSlider;
use App\Models\PrivacyPolicy;
use App\Models\User;
use App\Traits\UploadFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class PrivacyPolicyService
{
    use UploadFile;

    public function show($request){

        if ($request->ajax()) {
            $data = new PrivacyPolicy();

            $data = $data->first();

            return Response::json($data);
        }
        return view('home');

    }

    public function store($request)
    {
        try {
            DB::beginTransaction();
            $privacyPolicy = PrivacyPolicy::first();
            $privacyPolicy->description = $request->description;
            $privacyPolicy->save();

            DB::commit();
            return Response::json(['isSuccess' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::json(["message" => $e->getMessage()], 400);
        }
    }

}
