<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\OrderRequest;
use App\Http\Requests\Api\User\StoreTransactionIdRequest;
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
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function placeOrder(OrderRequest $request)
    {

        $address = Address::whereId($request->address_id)->first();
        $box = Box::whereId($request->box_id)->first();
//        todo::validate that total price less than max
        if ($request->main_category_id != null) {
            $products_sum = Product::whereIn('id', $request->products_id)
                ->sum('sel_price');
            if ($products_sum > $box->max_price) {
                return msg(false, trans('lang.invalid_products'), failed());
            }
        }

        if ($address->location == "in_riyadh") {
            $shipping_cost = (double)settings('in_riyadh_shipping_cost');
        } else {
            $shipping_cost = (double)settings('out_riyadh_shipping_cost');
        }

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

        return msgdata(true, trans('lang.Success_text'), $order ,success());

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


    public function storeOrderTransactionId(StoreTransactionIdRequest $request)
    {
        $order = Order::whereId($request->order_id)
            ->update([
                'transaction_id' => $request->transaction_id,
                'payment_method' => $request->payment_method,
            ]);

        return msg(true, trans('lang.Success_text'), success());
    }

    public function payOrder(Request $request)
    {
        $payment = $this->checkPayment($request->tap_id);
        if (isset($payment->status) && $payment->status == 'CAPTURED') {
            try {
                DB::beginTransaction();
                // find and update order by transaction_id
                $order = Order::where('transaction_id', $request->tap_id)
                    ->update([
                        "payment_status" => "paid"
                    ]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }
            return msg(true, trans('lang.Success_text'), success());
        } else {
            return msg(false, trans('lang.Message_Fail'), failed());
        }
    }

    public function checkPayment($charge_id)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.tap.company/v2/charges/" . $charge_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer sk_test_pJ8K61wBTgO3WzXRaf5omI7D",
                "accept: application/json",
                "content-type: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

//        if ($err) {
//            echo "cURL Error #:" . $err;
//        } else {
//        }
        return json_decode($response);
    }


}
