<?php

namespace App\Http\Controllers;

use App\Models\AboutUsData;
use App\Models\Award;
use App\Models\Categories;
use App\Models\ContactUs;
use App\Models\FAQ;
use App\Models\Flavor;
use App\Models\HomeHighlighty;
use App\Models\HomeIngredients;
use App\Models\HomeRomantic;
use App\Models\HomeSlider;
use App\Models\HomeVideo;
use App\Models\Message;
use App\Models\News;
use App\Models\Partners;
use App\Models\PrivacyPolicy;
use App\Models\Product;
use App\Models\ProductFlavor;
use App\Models\Subscriptions;
use App\Models\Term;
use App\Models\User;
use App\Models\UserCart;
use App\Models\UserProfile;
use App\Models\UserWishList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HomeController extends BaseController
{
    public function getHomeData(Request $request)
    {
        $sliders = HomeSlider::orderBy("position", "asc")->get();
        $highlighty = HomeHighlighty::first();
        $video = HomeVideo::first();
        $romantic = HomeRomantic::first();
        $ingredients = HomeIngredients::get();
        $contactUs = ContactUs::get();
        $data = [
            "sliders" => $sliders,
            "highlighty" => $highlighty,
            "video" => $video,
            "romantic" => $romantic,
            "ingredients" => $ingredients,
            "contactUs" => $contactUs,
        ];
        return $this->sendResponse($data, "");

    }

    public function getContactUs(Request $request)
    {
        $contactUs = ContactUs::get();
        $data = [
            "contactUs" => $contactUs,
        ];
        return $this->sendResponse($data, "");

    }

    public function getAboutUsData(Request $request)
    {
        $aboutUsData = AboutUsData::get();
        $data = [
            "aboutUsData" => $aboutUsData,
        ];
        return $this->sendResponse($data, "");

    }

    public function getAwards(Request $request)
    {
        $awards = Award::get();
        $data = [
            "awards" => $awards,
        ];
        return $this->sendResponse($data, "");

    }

    public function getNews(Request $request)
    {
        $newses = News::with("images")->orderBy("created_at", "DESC");
        if ($request->has("limit") and $request->limit and $request->has("offset") and $request->offset) {
            $newses = $newses->skip($request->offset)->skip($request->offset);

        }
        $newses = $newses->get();
        $data = [
            "newses" => $newses,
        ];
        return $this->sendResponse($data, "");

    }

    public function getFAQ(Request $request)
    {
        $faqs = FAQ::get();
        $data = [
            "faq" => $faqs,
        ];
        return $this->sendResponse($data, "");

    }

    public function getPrivacyPolicy(Request $request)
    {
        $privacyPolicy = PrivacyPolicy::get();
        $data = [
            "privacyPolicy" => $privacyPolicy,
        ];
        return $this->sendResponse($data, "");

    }

    public function getTerm(Request $request)
    {
        $term = Term::get();
        $data = [
            "term" => $term,
        ];
        return $this->sendResponse($data, "");

    }

    public function getCategories(Request $request)
    {
        $categories = Categories::orderBy("position");
        $categories = $categories->get();
        $data = [
            "categories" => $categories,
        ];
        return $this->sendResponse($data, "");

    }

    public function getFlavors(Request $request)
    {
        $flavors = new Flavor();
        if ($request->has("category_id") and $request->category_id) {
            $products = Product::where("category_id", $request->category_id)->pluck("id")->toArray();
            $productFlavors = ProductFlavor::whereIn("product_id", $products)->pluck("flavor_id")->toArray();
            $flavors = $flavors->whereIn("id", $productFlavors);
        }
        $flavors = $flavors->get();
        $data = [
            "flavors" => $flavors,
        ];
        return $this->sendResponse($data, "");

    }

    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $subscribe = new Subscriptions();
        $subscribe->full_name = $request->name;
        $subscribe->email = $request->email;
        $subscribe->save();
        return $this->sendResponse([], "");

    }

    public function new_partner(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $partner = new Partners();
        $partner->name = $request->name;
        $partner->company_name = $request->company_name;
        $partner->phone_number = $request->phone_number;
        $partner->email = $request->email;
        $partner->address = $request->address;
        $partner->description = $request->description;
        $partner->save();
        return $this->sendResponse([], "");

    }

    public function new_message(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'message' => 'required|string|max:1500',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $message = new Message();
        $message->name = $request->name;
        $message->email = $request->email;
        $message->message = $request->message;
        $message->save();
        return $this->sendResponse([], "");

    }

    public function getUserInfo(Request $request)
    {
        $data = [
            "user" => Auth::user()
        ];
        return $this->sendResponse($data, "");

    }

    public function addToCart(Request $request)
    {
        if (!$request->has("product_id") or !$request->product_id or !Product::find($request->product_id)) {
            return $this->sendError("Product is required");
        }
        $exist = UserCart::where("user_id", Auth::user()->id)->where("product_id", $request->product_id)->first();
        if ($exist) {
            $exist->delete();
            return $this->sendResponse([], "Deleted");

        } else {
            $userCart = new UserCart();
            $userCart->user_id = Auth::user()->id;
            $userCart->product_id = $request->product_id;
            $userCart->save();
            return $this->sendResponse([], "Added");
        }

    }


    public function acceptShowModal(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $user->is_show = true;
        $user->save();
        return $this->sendResponse([], "Success");
    }

    public function getUserCart(Request $request)
    {

        $userCarts = UserCart::where("user_id", Auth::user()->id)->get();
        $data = [
            "userCarts" => $userCarts
        ];
        return $this->sendResponse($data, "");

    }

    public function addToWishList(Request $request)
    {
        if (!$request->has("product_id") or !$request->product_id or !Product::find($request->product_id)) {
            return $this->sendError("Product is required");
        }
        $exist = UserWishList::where("user_id", Auth::user()->id)->where("product_id", $request->product_id)->first();
        if ($exist) {
            $exist->delete();
            return $this->sendResponse([], "Deleted");

        } else {
            $userWishList = new UserWishList();
            $userWishList->user_id = Auth::user()->id;
            $userWishList->product_id = $request->product_id;
            $userWishList->save();
            return $this->sendResponse([], "Added");
        }

    }


    public function getUserWishList(Request $request)
    {

        $userWishLists = UserWishList::where("user_id", Auth::user()->id)->get();
        $data = [
            "userWishLists" => $userWishLists
        ];
        return $this->sendResponse($data, "");

    }

    public function storeProfile(Request $request)
    {
        $profile = UserProfile::where("user_id", Auth::user()->id)->first();
        if (!$profile) {
            $profile = new UserProfile();
            $profile->user_id = Auth::user()->id;
        }
        $profile->email = Auth::user()->email ?? "";
        $profile->name = $request->name ?? "";
        $profile->surname = $request->surname ?? "";
        $profile->phone_number = $request->phone_number ?? "";
        $profile->country = $request->country ?? "";
        $profile->city = $request->city ?? "";
        $profile->address = $request->address ?? "";
        $profile->company_name = $request->company_name ?? "";
        $profile->apartment = $request->apartment ?? "";
        $profile->state = $request->state ?? "";
        $profile->zip_code = $request->zip_code ?? "";
        $profile->notes = $request->notes ?? "";
        $profile->type = $request->type ?? "car";
        $profile->save();
        $authUser = User::find(Auth::user()->id);
        $authUser->name = $profile->name . " " . $profile->surname;
        $authUser->save();
        return $this->sendResponse([], "");

    }

    public function getProfile(Request $request)
    {
        $profile = UserProfile::where("user_id", Auth::user()->id)->first();
        $data = [
            "profile" => $profile
        ];
        return $this->sendResponse($data, "");

    }

}
