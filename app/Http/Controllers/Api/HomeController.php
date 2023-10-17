<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\BoxDetailsRequest;
use App\Http\Requests\Api\User\executePayRequest;
use App\Http\Requests\Api\User\SaveSizesDataRequest;
use App\Http\Requests\Api\User\UserRequest;
use App\Http\Resources\Api\User\BoxCategoriesFinalResource;
use App\Http\Resources\Api\User\BoxFinalResource;
use App\Http\Resources\Api\User\BoxResource;
use App\Http\Resources\Api\User\CategoryResource;
use App\Http\Resources\Api\User\GiftResource;
use App\Http\Resources\Api\User\MainCategoryResource;
use App\Models\Box;
use App\Models\BoxCategory;
use App\Models\Gift;
use App\Models\GiftHistory;
use App\Models\GiftMoneyDetail;
use App\Models\MainCategory;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Arr;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function home()
    {
        $slider_image = Setting::where('key', 'slider_image')->first();
        $data['slider'] = $slider_image->image;
        $data['main_categories'] = MainCategoryResource::collection(MainCategory::orderBy('id', 'asc')->get());
        return msgdata(true, trans('lang.data_display_success'), $data, success());
    }

    public function saveSizesData(SaveSizesDataRequest $request)
    {
        $data = $request->validated();
        $slider_images = [];
        $boxes = Box::where('is_offer', 0)
            ->where('main_category_id', $data['main_category_id'])
            ->orderBy('id', 'asc')->get();


        foreach ($boxes as $key => $box) {
            $product_array = [];
            $categories = $box->categoriesByData($data['main_category_id'], $data);
            $minPrice = $box->min_price;
            $maxPrice = $box->max_price;

            foreach ($categories as $category) {
                foreach ($category->randomProducts as $product) {
                    array_push($product_array, $product);
                }

            }
            $box->products = generateArray($product_array, $minPrice, $maxPrice);
//            $box->products = $product_array;

      
            array_push($slider_images, $box->slider_image);


        }


        $result['boxes'] = BoxFinalResource::customCollection($boxes, $data);

        $result['slider_images'] = $slider_images;
        return msgdata(true, trans('lang.data_display_success'), $result, success());
    }

    public function executePay(executePayRequest $request)
    {
        $data = $request->validated();
        $order = Order::whereId($data['order_id'])->first();
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
                    $product_gift = Gift::whereHas('boxes', function ($q) use ($order) {
                        $q->where('boxes.id', $order->box_id);
                    })
                        ->whereHas('mainCategories', function ($q) use ($order) {
                            $q->where('main_categories.id', $order->main_category_id);
                        })
                        ->where('type', 'product')->inRandomOrder()->first();

                    if (!$product_gift) {
                        $gift = Gift::where('type', 'money')->where('money_remain', '>', 0)->inRandomOrder()->first();
                        if ($gift) {
                            $product_gift = $this->gift_money($gift, $order);
                        }
                    } else {
                        GiftHistory::create(['user_id' => $order->user_id, 'type' => 'product']);
                    }
                } else {
                    $gift = Gift::where('type', 'money')->where('money_remain', '>', 0)->inRandomOrder()->first();

                    if ($gift) {
                        $product_gift = $this->gift_money($gift, $order);
                    } else {
                        $product_gift = Gift::whereHas('boxes', function ($q) use ($order) {
                            $q->where('boxes.id', $order->box_id);
                        })
                            ->whereHas('mainCategories', function ($q) use ($order) {
                                $q->where('main_categories.id', $order->main_category_id);
                            })
                            ->where('type', 'product')->inRandomOrder()->first();
                        if ($product_gift) {
                            GiftHistory::create(['user_id' => $order->user_id, 'type' => 'product']);
                        }

                    }
                }
            } else {

                if ($last_gift->type == 'product') {
                    $product_gift = Gift::whereHas('boxes', function ($q) use ($order) {
                        $q->where('boxes.id', $order->box_id);
                    })
                        ->whereHas('mainCategories', function ($q) use ($order) {
                            $q->where('main_categories.id', $order->main_category_id);
                        })
                        ->where('type', 'product')->inRandomOrder()->first();
                    if (!$product_gift) {
                        $gift = Gift::where('type', 'money')->where('money_remain', '>', 0)->inRandomOrder()->first();
                        if ($gift) {
                            $product_gift = $this->gift_money($gift, $order);
                        }
                    } else {
                        GiftHistory::create(['user_id' => $order->user_id, 'type' => 'product']);
                    }
                } else {
                    $gift = Gift::where('type', 'money')->where('money_remain', '>', 0)->inRandomOrder()->first();
                    if ($gift) {
                        $product_gift = $this->gift_money($gift, $order);
                    } else {
                        $product_gift = Gift::whereHas('boxes', function ($q) use ($order) {
                            $q->where('boxes.id', $order->box_id);
                        })
                            ->whereHas('mainCategories', function ($q) use ($order) {
                                $q->where('main_categories.id', $order->main_category_id);
                            })
                            ->where('type', 'product')->inRandomOrder()->first();
                        if ($product_gift) {
                            GiftHistory::create(['user_id' => $order->user_id, 'type' => 'product']);
                        }
                    }
                }
            }
        } else {
            $gift = Gift::where('type', 'money')->where('money_remain', '>', 0)->inRandomOrder()->first();
            if ($gift) {
                $product_gift = $this->gift_money($gift, $order);
            } else {
                $product_gift = Gift::whereHas('boxes', function ($q) use ($order) {
                    $q->where('boxes.id', $order->box_id);
                })
                    ->whereHas('mainCategories', function ($q) use ($order) {
                        $q->where('main_categories.id', $order->main_category_id);
                    })
                    ->where('type', 'product')->inRandomOrder()->first();
                if ($product_gift) {
                    GiftHistory::create(['user_id' => $order->user_id, 'type' => 'product']);
                }
            }
        }
        if ($product_gift) {

            $response = new GiftResource($product_gift);
            $order_data['payment_status'] = 'paid';
            $order_data['payment_method'] = $data['payment_method'];

            $order_data['gift_type'] = $response['type'] ? 'product' : 'money';
            $order_data['gift_data'] = json_encode($response);
            if (!$response['type']) {
                $order_data['gift_money'] = $product_gift->amount;
            }
            Order::whereId($data['order_id'])->update($order_data);
            return msgdata(true, trans('lang.data_display_success'), $response, success());
        } else {
            return msg(true, trans('lang.no_gift_found'), failed());

        }

    }

    public function gift_money($gift, $order)
    {
        $product_gift = GiftMoneyDetail::where('gift_id', $gift->id)->where('is_selected', 0)->inRandomOrder()->first();
        if ($product_gift) {
            GiftHistory::create(['user_id' => $order->user_id, 'type' => 'money']);
            $product_gift->is_selected = 1;
            $product_gift->save();
            $gift->money_remain = $gift->money_remain - $product_gift->amount;
            $gift->save();
            return $product_gift;
        }

    }


    public function saveSizesDataBox(SaveSizesDataRequest $request, $id)
    {
        $data = $request->validated();
        $slider_image = [];
        $boxes = Box::where('is_offer', 0)
            ->where('main_category_id', $data['main_category_id'])
            ->orderBy('id', 'asc')
            ->whereId($id)
            ->get();


        foreach ($boxes as $key => $box) {
            $product_array = [];
            $categories = $box->categoriesByData($data['main_category_id'], $data);
            $minPrice = $box->min_price;
            $maxPrice = $box->max_price;

            foreach ($categories as $category) {
                foreach ($category->randomProducts as $product) {
                    array_push($product_array, $product);
                }

            }
            $box->products = generateArray($product_array, $minPrice, $maxPrice);

        }

        $result['boxes'] = BoxFinalResource::customCollection($boxes, $data);
        return msgdata(true, trans('lang.data_display_success'), $result, success());
    }

    public function generate_gift()
    {
        $slider_image = Setting::where('key', 'slider_image')->first();
        $data['slider'] = $slider_image->image;
        $data['main_categories'] = MainCategoryResource::collection(MainCategory::orderBy('id', 'asc')->get());
        return msgdata(true, trans('lang.data_display_success'), $data, success());
    }

}

