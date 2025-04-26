<?php


namespace App\Services;


use App\Models\ContactUs;
use App\Models\HomeIngredients;
use App\Models\HomeSlider;
use App\Models\User;
use App\Traits\UploadFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class HomeIngredientService
{
    use UploadFile;

    public function show($request){

        if ($request->ajax()) {
            $sortOrder = (($request->has('sortDesc') and $request->sortDesc == 'true') ? 'DESC' : 'ASC');
            $sortBy = (($request->has('sortBy') and $request->sortBy != '') ? $request->sortBy : 'id');
            $home = new HomeIngredients();

            $home = $home->orderBy($sortBy, $sortOrder)->paginate($request->perPage);

            return Response::json($home);
        }
        return view('home');

    }

    public function store($request)
    {
        try {
            DB::beginTransaction();
            if ($request->has('id') AND $request->id)
                $home = HomeIngredients::find($request->id);
            else
                $home = new HomeIngredients();

            if ($request->hasFile('image_path')) {
                $image_path = $home->image_path ?? null;
                $image = $request->file('image_path');
                $home->image_path = $this->upload($image, "sliders", $image_path);
            }
            $home->title = $request->title;
            $home->description = $request->description;
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
            $home = HomeIngredients::find($id);
            if(!$home){
                return Response::json(['isSuccess' => false, 'message' => "Not found"]);
            }

            if($home->image_path){
                $this->delete($home->image_path);
            }
            $home->delete();
            return Response::json(['isSuccess' => true, 'message' => "Deleted"]);

        } catch (\Exception $e) {
            return Response::json(['isSuccess' => false, 'message' => $e->getMessage()],400);
        }
    }


}
