<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\OrderRequest;
use App\Http\Requests\Api\User\StoreTransactionIdRequest;
use App\Http\Resources\Api\User\AddressesResources;
use App\Http\Resources\Api\User\GiftResource;
use App\Http\Resources\Api\User\OrderDetailsResource;
use App\Http\Resources\Api\User\OrderResource;
use App\Models\Address;
use App\Models\Box;
use App\Models\Gift;
use App\Models\GiftHistory;
use App\Models\GiftMoneyDetail;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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

        $product_gift = $this->generateGift($request);

        if ($product_gift) {

            $response = new GiftResource($product_gift);

            $order = Order::create([
                "user_id" => Auth::guard('user')->id(),
                "box_id" => $request->box_id,
                "address_data" => $address,
                "main_category_id" => $request->main_category_id,
                "payment_method" => "visa",
                "price" => $box->price,
                "shipping_cost" => $shipping_cost,
                "total" => $shipping_cost + $box->price,
                'is_offer' => $is_offer,

                'gift_type' => $response['type'] ? 'product' : 'money',
                'gift_data' => json_encode($response),
                'gift_money' => !$response['type'] ? $product_gift->amount : null,

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


            $data['gift'] = $response;
            $order = Order::whereId($order->id)->first();
            $data['order'] = new OrderDetailsResource($order);

            return msgdata(true, trans('lang.Success_text'), $data, success());
        } else {
            return msg(true, trans('lang.no_gift_found'), failed());

        }

    }

    public function generateGift($request)
    {
        //check gift type in queue ...
        $money_gifts = settings('money_gifts');  // 2
        $product_gifts = settings('product_gifts');  //4

        $last_gift = GiftHistory::orderBy('id', 'desc')->first();
        if ($last_gift) {
            if ($last_gift->type == 'money') {
                $take_number = $money_gifts;
            } else {
                $take_number = $product_gifts;

            }
            $last_gifts = GiftHistory::orderBy('id', 'desc')->get()->take($take_number);

            if ($take_number <= $last_gifts->where('type', $last_gift->type)->count()) {
                //enter here if reached max
                if ($last_gift->type == 'money') {
                    $product_gift = Gift::whereHas('boxes', function ($q) use ($request) {
                        $q->where('boxes.id', $request->box_id);
                    })
                        ->whereHas('mainCategories', function ($q) use ($request) {
                            $q->where('main_categories.id', $request->main_category_id);
                        })
                        ->where('type', 'product')->inRandomOrder()->first();

                    if (!$product_gift) {
                        $gift = Gift::where('type', 'money')->where('money_remain', '>', 0)->inRandomOrder()->first();
                        if ($gift) {
                            $product_gift = $this->gift_money($gift);
                        }
                    } else {
                        GiftHistory::create(['user_id' => Auth::guard('user')->id(), 'type' => 'product']);
                    }
                } else {
                    $gift = Gift::where('type', 'money')->where('money_remain', '>', 0)->inRandomOrder()->first();

                    if ($gift) {
                        $product_gift = $this->gift_money($gift);
                    } else {
                        $product_gift = Gift::whereHas('boxes', function ($q) use ($request) {
                            $q->where('boxes.id', $request->box_id);
                        })
                            ->whereHas('mainCategories', function ($q) use ($request) {
                                $q->where('main_categories.id', $request->main_category_id);
                            })
                            ->where('type', 'product')->inRandomOrder()->first();
                        if ($product_gift) {
                            GiftHistory::create(['user_id' => Auth::guard('user')->id(), 'type' => 'product']);
                        }

                    }
                }
            } else {

                if ($last_gift->type == 'product') {
                    $product_gift = Gift::whereHas('boxes', function ($q) use ($request) {
                        $q->where('boxes.id', $request->box_id);
                    })
                        ->whereHas('mainCategories', function ($q) use ($request) {
                            $q->where('main_categories.id', $request->main_category_id);
                        })
                        ->where('type', 'product')->inRandomOrder()->first();
                    if (!$product_gift) {
                        $gift = Gift::where('type', 'money')->where('money_remain', '>', 0)->inRandomOrder()->first();
                        if ($gift) {
                            $product_gift = $this->gift_money($gift);
                        }
                    } else {
                        GiftHistory::create(['user_id' => Auth::guard('user')->id(), 'type' => 'product']);
                    }
                } else {
                    $gift = Gift::where('type', 'money')->where('money_remain', '>', 0)->inRandomOrder()->first();
                    if ($gift) {
                        $product_gift = $this->gift_money($gift);
                    } else {
                        $product_gift = Gift::whereHas('boxes', function ($q) use ($request) {
                            $q->where('boxes.id', $request->box_id);
                        })
                            ->whereHas('mainCategories', function ($q) use ($request) {
                                $q->where('main_categories.id', $request->main_category_id);
                            })
                            ->where('type', 'product')->inRandomOrder()->first();
                        if ($product_gift) {
                            GiftHistory::create(['user_id' => Auth::guard('user')->id(), 'type' => 'product']);
                        }
                    }
                }
            }
        } else {
            $gift = Gift::where('type', 'money')->where('money_remain', '>', 0)->inRandomOrder()->first();
            if ($gift) {
                $product_gift = $this->gift_money($gift);
            } else {
                $product_gift = Gift::whereHas('boxes', function ($q) use ($request) {
                    $q->where('boxes.id', $request->box_id);
                })
                    ->whereHas('mainCategories', function ($q) use ($request) {
                        $q->where('main_categories.id', $request->main_category_id);
                    })
                    ->where('type', 'product')->inRandomOrder()->first();
                if ($product_gift) {
                    GiftHistory::create(['user_id' => Auth::guard('user')->id(), 'type' => 'product']);
                }
            }
        }
        return $product_gift;

    }


    public function gift_money($gift)
    {
        $product_gift = GiftMoneyDetail::where('gift_id', $gift->id)->where('is_selected', 0)->inRandomOrder()->first();
        if ($product_gift) {
            GiftHistory::create(['user_id' => Auth::guard('user')->id(), 'type' => 'money']);
            $product_gift->is_selected = 1;
            $product_gift->save();
            $gift->money_remain = $gift->money_remain - $product_gift->amount;
            $gift->save();
            return $product_gift;
        }
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

    public function generatePaymentLink()
    {
        $user = Auth::guard('user')->user();

        $amount = 100;
        $error_url = "https://bunybox.net/public/api/pay-error";
        $callback_url = "https://bunybox.net/public/api/orders/pay-order";

        $first_name = $user->name;
        $last_name = $user->name;
        $email = $user->email;
        $code = $user->country_code;
        $phone = $user->phone;

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.tap.company/v2/charges",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\"amount\":$amount,\"currency\":\"SAR\",\"customer_initiated\":true,\"threeDSecure\":true,\"save_card\":false,\"description\":\"Please Complete The Current Payment\",\"metadata\":{\"udf1\":\"Metadata 1\"},\"reference\":{\"transaction\":\"txn_01\",\"order\":\"ord_01\"},\"receipt\":{\"email\":true,\"sms\":true},\"customer\":{\"first_name\":\"$first_name\",\"middle_name\":\"-\",\"last_name\":\"$last_name\",\"email\":\"$email\",\"phone\":{\"country_code\":$code,\"number\":$phone}},\"source\":{\"id\":\"src_all\"},\"post\":{\"url\":\"$callback_url\"},\"redirect\":{\"url\":\"$callback_url\"}}",
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer sk_test_pJ8K61wBTgO3WzXRaf5omI7D",
                "accept: application/json",
                "content-type: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        }
        $result = json_decode($response);
//        dd($result);
        // status = INITIATED
        return msgdata(true, trans('lang.Success_text'), $result, success());
    }

}
