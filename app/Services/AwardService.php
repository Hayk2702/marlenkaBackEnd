<?php


namespace App\Services;


use App\Models\AboutUsData;
use App\Models\Award;
use App\Models\ContactUs;
use App\Models\HomeSlider;
use App\Models\User;
use App\Traits\UploadFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class AwardService
{
    use UploadFile;

    public function show($request){

        if ($request->ajax()) {
            $sortOrder = (($request->has('sortDesc') and $request->sortDesc == 'true') ? 'DESC' : 'ASC');
            $sortBy = (($request->has('sortBy') and $request->sortBy != '') ? $request->sortBy : 'id');
            $data = new Award();

            $data = $data->orderBy($sortBy, $sortOrder)->paginate($request->perPage);

            return Response::json($data);
        }
        return view('home');

    }

    public function store($request)
    {
        try {
            DB::beginTransaction();
            if ($request->has('id') AND $request->id)
                $award = Award::find($request->id);
            else
                $award = new Award();

            $award->title = $request->title;
            $award->description = $request->description;
            $award->save();

            DB::commit();
            return Response::json(['isSuccess' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::json(["message" => $e->getMessage()], 400);
        }
    }

    public function destroy($id){

        try {
            $award = Award::find($id);
            if(!$award){
                return Response::json(['isSuccess' => false, 'message' => "Not found"]);
            }

            $award->delete();
            return Response::json(['isSuccess' => true, 'message' => "Deleted"]);

        } catch (\Exception $e) {
            return Response::json(['isSuccess' => false, 'message' => $e->getMessage()],400);
        }
    }

}
