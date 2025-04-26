<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderProducts;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class OrderService
{
    public function show($request)
    {

        if ($request->ajax()) {
            $sortOrder = (($request->has('sortDesc') and $request->sortDesc == 'true') ? 'DESC' : 'ASC');
            $sortBy = (($request->has('sortBy') and $request->sortBy != '') ? $request->sortBy : 'id');

            $orders = Order::select(
                'orders.*'
            );

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
                        if ($filter->key->value == 'orders.created_at') {
                            $timezone = config('app.timezone');
                            $date = new DateTime($filter->text);
                            $date->setTimezone(new DateTimeZone($timezone));
                            $text = $date->format('Y-m-d');
                            if ($cond == "AND") {
                                $orders = $orders->whereDate('orders.created_at', $action, (($action == "LIKE") ? '%' . $text . '%' : $text));
                            } else {
                                $orders = $orders->orWhereDate('orders.created_at', $action, (($action == "LIKE") ? '%' . $text . '%' : $text));
                            }
                        }else{
                            //                        $filter->key->value = 'orders.' . $filter->key->value;

                            if ($cond == "AND") {
                                $orders = $orders->where($filter->key->value, $action, $text);
                            } else {
                                $orders = $orders->orWere($filter->key->value, $action, $text);
                            }
                        }

                    }
                }
            }

            if($request->status == "order"){
                $orders = $orders->where("status",0);
            }else if($request->status == "finish_order"){
                $orders = $orders->where("status",1);
            }else {
                $orders = $orders->where("status",-1);
            }

            $orders = $orders->with("orderProducts.product")->orderBy($sortBy, $sortOrder)->paginate($request->perPage);
            return Response::json($orders);
        }
        return view('home');
    }


    public function finishOrder($request)
    {

        DB::beginTransaction();
        try {
            $order = Order::find($request->order);
            $order->status = 1;
            $order->save();
            DB::commit();
            return Response::json(['isSuccess' => true], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::json(["message" => $e->getMessage()], 400);
        }
    }


}
