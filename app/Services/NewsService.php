<?php


namespace App\Services;


use App\Models\AboutUsData;
use App\Models\ContactUs;
use App\Models\HomeSlider;
use App\Models\News;
use App\Models\NewsImages;
use App\Models\User;
use App\Traits\UploadFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class NewsService
{
    use UploadFile;

    public function show($request){

        if ($request->ajax()) {
            $sortOrder = (($request->has('sortDesc') and $request->sortDesc == 'true') ? 'DESC' : 'ASC');
            $sortBy = (($request->has('sortBy') and $request->sortBy != '') ? $request->sortBy : 'id');
            $data = new News();

            $data = $data->with("images")->orderBy($sortBy, $sortOrder)->paginate($request->perPage);

            return Response::json($data);
        }
        return view('home');

    }

    public function store($request)
    {
        try {
            DB::beginTransaction();
            if ($request->has('id') AND $request->id)
                $news = News::find($request->id);
            else
                $news = new News();

            $news->title = $request->title;
            $news->youtube_codes = $request->youtube_codes;
            $news->description = $request->description;
            $news->long_description = $request->long_description;
            $news->save();

            // Handle images
            $existingImages = $request->existing_images ?? [];
            $currentImages = NewsImages::where('news_id', $news->id)->pluck('image_path')->toArray();

            foreach ($currentImages as $currentImage) {
                if (!in_array($currentImage, $existingImages)) {
                    $this->delete($currentImage);
                    NewsImages::where('image_path', $currentImage)->delete();
                }
            }

            // Save new images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $newImage = new NewsImages();
                    $newImage->news_id = $news->id;
                    $newImagePath = $this->upload($image, 'news', null);  // Upload image and get the path
                    $newImage->image_path = $newImagePath;
                    $newImage->save();
                }
            }

            DB::commit();
            return Response::json(['isSuccess' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::json(["message" => $e->getMessage()], 400);
        }
    }

    public function destroy($id){

        try {
            $news = News::find($id);
            if(!$news){
                return Response::json(['isSuccess' => false, 'message' => "Not found"]);
            }

            $images  = NewsImages::where("news_id",$news->id)->get();
            foreach ($images as $image){
                $this->delete($image->image_path);
                $image->delete();
            }

            $news->delete();
            return Response::json(['isSuccess' => true, 'message' => "Deleted"]);

        } catch (\Exception $e) {
            return Response::json(['isSuccess' => false, 'message' => $e->getMessage()],400);
        }
    }

}
