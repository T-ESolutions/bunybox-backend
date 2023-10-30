<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\OrderRequest;
use App\Http\Resources\Api\User\AddressesResources;
use App\Http\Resources\Api\User\OrderDetailsResource;
use App\Http\Resources\Api\User\OrderResource;
use App\Models\Address;
use App\Models\Box;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function placeOrder(OrderRequest $request)
    {

        $address = Address::whereId($request->address_id)->first();

//        todo::validate that total price less than max

        if ($address->location == "in_riyadh") {
            $shipping_cost = (double)settings('in_riyadh_shipping_cost');
        } else {
            $shipping_cost = (double)settings('out_riyadh_shipping_cost');
        }
        $box = Box::whereId($request->box_id)->first();
        if (isset($request->is_offer) && $request->is_offer == 1) {
            $is_offer = 1;
        } else {
            $is_offer = 0;
        }
        $order = Order::create([
            "user_id" => Auth::guard('user')->id(),
            "box_id" => $request->box_id,
            "address_data" => $address,
            "main_category_id" => $request->main_category_id,
            "payment_method" => "visa",
            "price" => $box->price,
            "shipping_cost" => $shipping_cost,
            "total" => $shipping_cost + $box->price,
            'is_offer' => $is_offer

        ]);

        foreach ($request->products_id as $product_id) {
            $product = Product::whereId($product_id)->first();
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product_id,
                'category_id' => $product->category_id,
                'type' => "basic",
            ]);
        }

        return msg(true, trans('lang.Success_text'), success());

    }

    public function orders()
    {
        $user_id = Auth::guard('user')->id();
        $orders = Order::where('user_id', $user_id)
            ->orderBy('id', 'desc')
            ->with(['mainCategory', 'items', 'box'])
            ->paginate(10);


        $data = OrderResource::collection($orders)->response()->getData(true);
        return msgdata(true, trans('lang.data_display_success'), $data, success());
    }

    public function orderDetails($id)
    {
        $user_id = Auth::guard('user')->id();
        $order = Order::where('user_id', $user_id)
            ->where('id', $id)
            ->with(['mainCategory', 'items', 'box'])
            ->firstOrFail();


        $data = new OrderDetailsResource($order);
        return msgdata(true, trans('lang.data_display_success'), $data, success());
    }
}
