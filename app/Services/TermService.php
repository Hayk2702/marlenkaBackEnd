<?php


namespace App\Services;


use App\Models\AboutUsData;
use App\Models\Award;
use App\Models\ContactUs;
use App\Models\FAQ;
use App\Models\HomeSlider;
use App\Models\PrivacyPolicy;
use App\Models\Term;
use App\Models\User;
use App\Traits\UploadFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class TermService
{
    use UploadFile;

    public function show($request){

        if ($request->ajax()) {
            $data = new Term();

            $data = $data->first();

            return Response::json($data);
        }
        return view('home');

    }

    public function store($request)
    {
        try {
            DB::beginTransaction();
            $term = Term::first();
            $term->description = $request->description;
            $term->save();

            DB::commit();
            return Response::json(['isSuccess' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::json(["message" => $e->getMessage()], 400);
        }
    }

}
