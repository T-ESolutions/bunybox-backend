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
        $data['check_token'] = auth('user')->check() ? true : false;
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

//            if (count($box->products) != 0){
            array_push($slider_images, $box->slider_image);
//
//            }

        }
//        $boxes = $boxes->filter(function ($box) {
//            return count($box->products) > 0;
//        });

        $result['boxes'] = BoxFinalResource::customCollection($boxes, $data);

        $result['slider_images'] = $slider_images;
        return msgdata(true, trans('lang.data_display_success'), $result, success());
    }

    public function executePay(executePayRequest $request)
    {
        $data = $request->validated();
        $order_data['payment_status'] = 'paid';
        $order_data['payment_method'] = $data['payment_method'];
        Order::whereId($data['order_id'])->update($order_data);
        return msg(true, trans('lang.data_display_success'), success());
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

