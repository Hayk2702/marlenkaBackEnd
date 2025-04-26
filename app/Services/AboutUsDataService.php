<?php


namespace App\Services;


use App\Models\AboutUsData;
use App\Models\ContactUs;
use App\Models\HomeSlider;
use App\Models\User;
use App\Traits\UploadFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class AboutUsDataService
{
    use UploadFile;

    public function show($request){

        if ($request->ajax()) {
            $sortOrder = (($request->has('sortDesc') and $request->sortDesc == 'true') ? 'DESC' : 'ASC');
            $sortBy = (($request->has('sortBy') and $request->sortBy != '') ? $request->sortBy : 'id');
            $data = new AboutUsData();

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
                $aboutUsData = AboutUsData::find($request->id);
            else
                $aboutUsData = new AboutUsData();

            if ($request->hasFile('image_path')) {
                $image_path = $aboutUsData->image_path ?? null;
                $image = $request->file('image_path');
                $aboutUsData->image_path = $this->upload($image, "aboutUsData", $image_path);
            }

            $aboutUsData->title = $request->title;
            $aboutUsData->description = $request->description;
            $aboutUsData->save();

            DB::commit();
            return Response::json(['isSuccess' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::json(["message" => $e->getMessage()], 400);
        }
    }

    public function destroy($id){

        try {
            $aboutUsData = AboutUsData::find($id);
            if(!$aboutUsData){
                return Response::json(['isSuccess' => false, 'message' => "Not found"]);
            }

            if($aboutUsData->image_path){
                $this->delete($aboutUsData->image_path);
            }

            $aboutUsData->delete();
            return Response::json(['isSuccess' => true, 'message' => "Deleted"]);

        } catch (\Exception $e) {
            return Response::json(['isSuccess' => false, 'message' => $e->getMessage()],400);
        }
    }

    public function setMainAbout($request){

        try {
            if(!$request->has("id") OR !$request->id OR !$aboutUsData = AboutUsData::find($request->id)){
                return Response::json(['isSuccess' => false, 'message' => "Not found"]);
            }
            $aboutUsData->main = 1;
            $aboutUsData->save();
            AboutUsData::where("id", "!=", $request->id)->update(["main" => 0]);
            return Response::json(['isSuccess' => true]);

        } catch (\Exception $e) {
            return Response::json(['isSuccess' => false, 'message' => $e->getMessage()],400);
        }
    }


}
