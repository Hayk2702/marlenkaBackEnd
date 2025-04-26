<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProducts;
use App\Models\Product;
use App\Models\UserCard;
use App\Services\OrderService;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends BaseController
{
    public function __construct(OrderService $service)
    {
        $this->orderService = $service;
    }

    public function index(Request $request)
    {
        return $this->orderService->show($request);
    }
    public function finishOrder(Request $request)
    {
        return $this->orderService->finishOrder($request);
    }
    public function storeOrder(Request $request)
    {
        if(!$request->has("data") OR !$request->data){
            return $this->sendError("Data is incorrect");
        }
        if(!$request->type OR !$request->zip_code OR !$request->state OR !$request->address OR !$request->city OR !$request->email OR !$request->name OR !$request->surname OR !$request->phone_number OR !$request->country){
            return $this->sendError("Profile info is incorrect");
        }

        try {
            DB::beginTransaction();
            $order = new Order();
            $order->user_id = (Auth::user() AND Auth::user()->id) ? Auth::user()->id : -1;
            $order->transaction = "transaction";
            $order->payment_amount = 50;
            $order->payment_status = 1;
            $order->payment_method = "card";

            $order->name = $request->name ?? "";
            $order->surname = $request->surname ?? "";
            $order->email = $request->email ?? "";
            $order->phone_number = $request->phone_number ?? "";
            $order->country = $request->country ?? "";
            $order->city = $request->city ?? "";
            $order->address = $request->address ?? "";
            $order->company_name = $request->company_name ?? "";
            $order->apartment = $request->apartment ?? "";
            $order->state = $request->state ?? "";
            $order->zip_code = $request->zip_code ?? "";
            $order->notes = $request->notes ?? "";
            $order->type = $request->type ?? "car";
            $order->ip_address = $this->getRealIpAddr();
            $order->save();
            foreach ($request->data as $productData){
                if($productData["count"] AND $productData["count"] > 0){
                    $product = Product::find($productData["product_id"]);
                    if(!$product){
                        DB::rollBack();
                        return $this->sendError("Data is incorrect");
                    }
                    $orderProduct = new OrderProducts();
                    $orderProduct->order_id = $order->id;
                    $orderProduct->product_id = $product->id;
                    $orderProduct->price = $product->price;
                    $orderProduct->count = $productData["count"];
                    $orderProduct->save();
                }


            }

            DB::commit();
            return $this->sendResponse([],"");


        }catch (\Exception $e){
            DB::rollBack();
            return $this->sendError("Data is incorrect");

        }

    }

    function getRealIpAddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
        {
            $ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
        {
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
            $ip=$_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }


    public function getOrders(Request $request)
    {
        $orders = Order::where("user_id",Auth::user()->id);
        if($request->has("from") AND $request->from){
            $orders = $orders->whereDate('created_at', ">=",$request->from);

        }
        if($request->has("to") AND $request->to){

            $orders = $orders->whereDate('created_at', "<=",$request->to);

        }
        $orders = $orders->with("orderProducts.product");
        $orders = $orders->get();
        $data = [
            "orders" => $orders
        ];
        return $this->sendResponse($data,"");

    }

    public function getCards(Request $request)
    {
        $cards = UserCard::where("user_id",Auth::user()->id);

        $cards = $cards->get();
        $data = [
            "cards" => $cards
        ];
        return $this->sendResponse($data,"");

    }


    public function storeCard(Request $request)
    {
        try {
            DB::beginTransaction();
            if($request->has("id") AND $request->id){
                $card = UserCard::where("id",$request->id)->where("user_id",Auth::user()->id)->first();
                if(!$card){
                    DB::rollBack();
                    return $this->sendError("Data is incorrect");
                }
            }else{
                $card = new UserCard();
            }
            $card->user_id = (Auth::user() AND Auth::user()->id) ? Auth::user()->id : -1;
            $card->number = $request->number ?? null;
            $card->holder = $request->holder ?? null;
            $card->cvv = $request->cvv ?? null;
            $card->date = $request->date ?? null;
            $card->pin = $request->pin ?? null;
            $card->address = $request->address ?? null;
            $card->zip_code = $request->zip_code ?? null;
            $card->type = $request->type ?? null;
            $card->save();

            DB::commit();
            return $this->sendResponse([],"");


        }catch (\Exception $e){
            DB::rollBack();
            return $this->sendError("Data is incorrect");

        }

    }

    public function deleteCard(Request $request)
    {
        try {
            DB::beginTransaction();
            $id = $request->id ?? null;
            $card = UserCard::where("id",$id)->where("user_id",Auth::user()->id)->first();
            if(!$card){
                DB::rollBack();
                return $this->sendError("Data is incorrect");
            }
            $card->delete();
            DB::commit();
            return $this->sendResponse([],"");


        }catch (\Exception $e){
            DB::rollBack();
            return $this->sendError("Data is incorrect");

        }

    }

    public function setDefault(Request $request)
    {
        try {
            DB::beginTransaction();
            $id = $request->id ?? null;
            $card = UserCard::where("id",$id)->where("user_id",Auth::user()->id)->first();
            if(!$card){
                DB::rollBack();
                return $this->sendError("Data is incorrect");
            }
            UserCard::where("user_id",Auth::user()->id)->update(["default"=>0]);
            $card->default = 1;
            $card->save();
            DB::commit();
            return $this->sendResponse([],"");


        }catch (\Exception $e){
            DB::rollBack();
            return $this->sendError("Data is incorrect");

        }

    }


}
