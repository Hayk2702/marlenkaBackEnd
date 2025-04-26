<?php


namespace App\Services;


use App\Models\ContactUs;
use App\Models\HomeSlider;
use App\Models\Product;
use App\Models\ProductFlavor;
use App\Models\ProductImages;
use App\Models\ProductPackageTechnical;
use App\Models\ProductTechnicals;
use App\Models\User;
use App\Traits\UploadFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class ProductService
{
    use UploadFile;

    public function show($request){

        if ($request->ajax()) {
            $sortOrder = (($request->has('sortDesc') and $request->sortDesc == 'true') ? 'DESC' : 'ASC');
            $sortBy = (($request->has('sortBy') and $request->sortBy != '') ? $request->sortBy : 'id');
            $product = new Product();
            $filterArray = $request->filter;

            foreach ($filterArray as $index => $filter) {

                $filter = json_decode($filter);
                $cond = "AND";
                if ($index > 0) {
                    $cond = json_decode($filterArray[$index - 1])->condition ?? "AND";
                }
                if (property_exists($filter, 'action') and in_array($filter->action, ['LIKE', '=', '!=', '>', '<', '>=', '<='])) {
                    $action = $filter->action;
                } else {
                    $action = "LIKE";
                }

                if ($filter and $filter->key and $filter->key->value) {
                    if ($filter->text or $filter->text == 0) {
                        if ($action == "LIKE") {
                            $text = '%' . trim($filter->text) . '%';
                        } else {
                            $text = trim($filter->text);
                        }
                        if ($cond == "AND") {
                            $product = $product->where($filter->key->value, $action, $text);
                        } else {
                            $product = $product->orWere($filter->key->value, $action, $text);
                        }

                    }
                }
            }

            $product = $product->with("category","technicals","packageTechnicals","images","flavors.flavor");
            $product = $product->orderBy($sortBy, $sortOrder)->paginate($request->perPage);

            return Response::json($product);
        }
        return view('home');

    }

    public function store($request)
    {
        try {
            DB::beginTransaction();
            if ($request->has('id') AND $request->id)
                $product = Product::find($request->id);
            else
                $product = new Product();

            $product->name = $request->name;
            $product->description = $request->description;
            $product->category_id = $request->category_id;
            $product->details_one = $request->details_one;
            $product->details_two = $request->details_two;
            $product->details_three = $request->details_three;
            $product->price = $request->price;
            $product->status = $request->status;
            $product->serving = $request->serving;
            $product->isNew = $request->isNew;
            $product->save();

            ProductTechnicals::where("product_id",$product->id)->delete();
            if($request->technicals){
                foreach ($request->technicals as $technical){
                    if($technical["technical"] AND $technical["value"]){
                        $productTechnical = new ProductTechnicals();
                        $productTechnical->product_id = $product->id;
                        $productTechnical->technical = $technical["technical"];
                        $productTechnical->value = $technical["value"];
                        $productTechnical->save();
                    }

                }
            }

            ProductFlavor::where("product_id",$product->id)->delete();
            if($request->flavor_ids){
                foreach ($request->flavor_ids as $flavor){
                    $productFlavor = new ProductFlavor();
                    $productFlavor->product_id = $product->id;
                    $productFlavor->flavor_id = $flavor;
                    $productFlavor->save();

                }
            }

            ProductPackageTechnical::where("product_id",$product->id)->delete();
            if($request->packageTechnicals){
                foreach ($request->packageTechnicals as $technical){
                    if($technical["technical"] AND $technical["value"]){
                        $productPackageTechnical = new ProductPackageTechnical();
                        $productPackageTechnical->product_id = $product->id;
                        $productPackageTechnical->technical = $technical["technical"];
                        $productPackageTechnical->value = $technical["value"];
                        $productPackageTechnical->save();
                    }

                }
            }

            // Handle images
            $existingImages = $request->existing_images ?? [];
            $currentImages = ProductImages::where('product_id', $product->id)->pluck('image_path')->toArray();

            foreach ($currentImages as $currentImage) {
                if (!in_array($currentImage, $existingImages)) {
                    $this->delete($currentImage);
                    ProductImages::where('image_path', $currentImage)->delete();
                }
            }

            // Save new images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $newImage = new ProductImages();
                    $newImage->product_id = $product->id;
                    $newImagePath = $this->upload($image, 'products', null);  // Upload image and get the path
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
            $product = Product::find($id);
            if(!$product){
                return Response::json(['isSuccess' => false, 'message' => "Not found"]);
            }
            $images  = ProductImages::where("product_id",$product->id)->get();
            foreach ($images as $image){
                $this->delete($image->image_path);
                $image->delete();
            }
            ProductTechnicals::where("product_id",$product->id)->delete();
            ProductPackageTechnical::where("product_id",$product->id)->delete();

            $product->delete();
            return Response::json(['isSuccess' => true, 'message' => "Deleted"]);

        } catch (\Exception $e) {
            return Response::json(['isSuccess' => false, 'message' => $e->getMessage()],400);
        }
    }

}
