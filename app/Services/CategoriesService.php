<?php


namespace App\Services;


use App\Models\AboutUsData;
use App\Models\Categories;
use App\Models\ContactUs;
use App\Models\HomeSlider;
use App\Models\User;
use App\Traits\UploadFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class CategoriesService
{
    use UploadFile;

    public function show($request){

        if ($request->ajax()) {
            $sortOrder = (($request->has('sortDesc') and $request->sortDesc == 'true') ? 'DESC' : 'ASC');
            $sortBy = (($request->has('sortBy') and $request->sortBy != '') ? $request->sortBy : 'id');
            $data = new Categories();

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
                $category = Categories::find($request->id);
            else
                $category = new Categories();

            if ($request->hasFile('image_path')) {
                $image_path = $category->image_path ?? null;
                $image = $request->file('image_path');
                $category->image_path = $this->upload($image, "categories", $image_path);
            }

            $category->name = $request->name;
            $category->description = $request->description;
            $category->save();

            DB::commit();
            return Response::json(['isSuccess' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::json(["message" => $e->getMessage()], 400);
        }
    }

    public function destroy($id){

        try {
            $category = Categories::find($id);
            if(!$category){
                return Response::json(['isSuccess' => false, 'message' => "Not found"]);
            }

            if($category->image_path){
                $this->delete($category->image_path);
            }

            $category->delete();
            return Response::json(['isSuccess' => true, 'message' => "Deleted"]);

        } catch (\Exception $e) {
            return Response::json(['isSuccess' => false, 'message' => $e->getMessage()],400);
        }
    }

}
