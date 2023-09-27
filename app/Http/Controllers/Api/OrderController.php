<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\OrderRequest;
use App\Models\Address;
use App\Models\Box;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function placeOrder(OrderRequest $request)
    {

        $address = Address::whereId($request->address_id)->first();
        if ($address->location == "in_riyadh"){

        }else{

        }
        $box = Box::whereId($request->box_id)->first();
        $order = Order::create([
            "user_id" => Auth::guard('user')->id(),
            "box_id" => $request->box_id,
            "address_data" => $address,
            "main_category_id"=>$request->main_category_id,
            "payment_method"=>"visa",
            "price"=>$box->price,
            "shipping_cost",
            "total",
            "delivered_at",
            "is_offer",
            "gift_type",
            "gift_money",


        ]);


    }
}
