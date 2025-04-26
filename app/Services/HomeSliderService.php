<?php


namespace App\Services;


use App\Models\ContactUs;
use App\Models\HomeSlider;
use App\Models\User;
use App\Traits\UploadFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class HomeSliderService
{
    use UploadFile;

    public function show($request){

        if ($request->ajax()) {
            $sortOrder = (($request->has('sortDesc') and $request->sortDesc == 'true') ? 'DESC' : 'ASC');
            $sortBy = (($request->has('sortBy') and $request->sortBy != '') ? $request->sortBy : 'id');
            $home = new HomeSlider();

//            $home = $home->orderBy($sortBy, $sortOrder)->paginate($request->perPage);
            $home = $home->orderBy("position", "asc")->paginate($request->perPage);

            return Response::json($home);
        }
        return view('home');

    }

    public function store($request)
    {
        try {
            DB::beginTransaction();
            if ($request->has('id') AND $request->id)
                $home = HomeSlider::find($request->id);
            else
                $home = new HomeSlider();
            if ($request->hasFile('image_path')) {
                $image_path = $home->image_path ?? null;
                $image = $request->file('image_path');
                $home->image_path = $this->upload($image, "sliders", $image_path);
            }
            if ($request->hasFile('small_image_path')) {
                $image_path = $home->small_image_path ?? null;
                $image = $request->file('small_image_path');
                $home->small_image_path = $this->upload($image, "sliders", $image_path);
            }

            $home->title = $request->title;
            $home->description = $request->description;
            $home->product_id = $request->product_id;
            $home->category_id = $request->category_id;
            $home->save();

            DB::commit();
            return Response::json(['isSuccess' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::json(["message" => $e->getMessage()], 400);
        }
    }

    public function destroy($id){

        try {
            $home = HomeSlider::find($id);
            if(!$home){
                return Response::json(['isSuccess' => false, 'message' => "Not found"]);
            }

            if($home->image_path){
                $this->delete($home->image_path);
            }
            if($home->small_image_path){
                $this->delete($home->small_image_path);
            }
            $home->delete();
            return Response::json(['isSuccess' => true, 'message' => "Deleted"]);

        } catch (\Exception $e) {
            return Response::json(['isSuccess' => false, 'message' => $e->getMessage()],400);
        }
    }

    public function sliderPosition($request){

        try {
            foreach ($request->data as $index=>$value){
                $slider = HomeSlider::find($value);
                $slider->position = $index;
                $slider->save();
            }
            return Response::json(['isSuccess' => true, 'message' => "Deleted"]);

        } catch (\Exception $e) {
            return Response::json(['isSuccess' => false, 'message' => $e->getMessage()],400);
        }
    }


}
