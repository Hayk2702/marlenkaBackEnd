<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Models\Categories;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    private $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        return $this->productService->show($request);

    }

    public function store(ProductStoreRequest $request)
    {
        return $this->productService->store($request);
    }

    public function getProducts(Request $request)
    {
        $products = new Product();

        if($request->has("category_id") AND $request->category_id){
            $products =  $products->where("category_id",$request->category_id);
        }
        if($request->has("product_id") AND $request->product_id){
            $products =  $products->where("id",$request->product_id);
        }
        if($request->has("filter") AND $request->filter){
            $products = $products
                ->where("name","LIKE","%{$request->filter}%")
                ->orWhere("description","LIKE","%{$request->filter}%")
                ->orWhere("details_one","LIKE","%{$request->filter}%")
                ->orWhere("details_two","LIKE","%{$request->filter}%")
                ->orWhere("details_three","LIKE","%{$request->filter}%")
            ;
        }
        if($request->has("serving") AND $request->serving){
            switch ($request->serving){
                case 1:
                    $products = $products->where("serving",1);
                    break;
                case 2:
                    $products = $products->where("serving",2);
                    break;
                case 3:
                    $products = $products->where("serving",3);
                    break;
                case 4:
                    $products = $products->where("serving",4);
                    break;
            }
        }

        if($request->has("flavors") AND $request->flavors AND $flavors = json_decode($request->flavors) AND $flavors AND count($flavors)){
            $products = $products->whereHas('flavors', function ($query) use($flavors) {
                $query->whereIn('flavor_id', $flavors);
            });
        }
        if($request->has("offset") AND $request->offset){
            $products = $products->skip($request->offset);
        }
        if($request->has("limit") AND $request->limit){
            $products = $products->take($request->limit);
        }
        $products = $products->with("images","technicals","packageTechnicals","category","flavors")->get();
        $data = [
            "products" => $products,
        ];
        return $this->sendResponse($data,"");

    }

    public function getProductByFlavor(Request $request)
    {
        if(!$request->has("category_id") OR !$request->category_id OR !$request->has("flavor") OR !$request->flavor){
            $data = [
                "product" => null,
            ];
            return $this->sendResponse($data,"");
        }
        $products = new Product();
        $products =  $products->where("category_id",$request->category_id);
        $products = $products->whereHas('flavors', function ($query) use($request) {
            $query->where('flavor_id', $request->flavor);
        });

        $products = $products->with("images","technicals","packageTechnicals","category","flavors")->first();
        $data = [
            "product" => $products,
        ];
        return $this->sendResponse($data,"");

    }

    public function destroy($id)
    {
        return $this->productService->destroy($id);
    }
}
