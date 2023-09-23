<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\BoxDetailsRequest;
use App\Http\Requests\Api\User\SaveSizesDataRequest;
use App\Http\Requests\Api\User\UserRequest;
use App\Http\Resources\Api\User\BoxResource;
use App\Http\Resources\Api\User\CategoryResource;
use App\Http\Resources\Api\User\MainCategoryResource;
use App\Models\Box;
use App\Models\BoxCategory;
use App\Models\MainCategory;
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
        $boxes = Box::where('is_offer', 0)->where('main_category_id', $data['main_category_id'])->orderBy('id', 'asc')->get();


        $boxes = BoxResource::customCollection($boxes, $data);

        foreach ($boxes as $box) {
            $product_array[$box->id] = [];
            $resourceData = $box->toArray($box);
            $categories = $resourceData['resource_categories'];
            foreach ($categories as $category) {
                foreach ($category->products as $product) {
                    array_push($product_array[$box->id], $product);
                }
            }

            //compare box price ................
            $price_range = ['min' => $box->min_price, 'max' => $box->max_price];
            $result_arr = [];
            foreach ($product_array[$box->id] as $product_item) {
                $category_id = $product_item->category_id;
                $price = $product_item->price;
                if (!isset($result_arr[$category_id])) {
                    $result_arr[$category_id] = array_fill(0, count($price_range), 0);
                }
                foreach ($price_range as $key => $item) {
                    $item_min = $item['min'];
                    $item_max = $item['max'];
                    if($price >= $item_min && $price <= $item_max) {
                        $result_arr[$category_id][$key] = $price;
                    }
                }
            }
            return $result_arr;


        }
//        return $product_array;
        $result['boxes'] = BoxResource::customCollection($boxes, $data);
        return msgdata(true, trans('lang.data_display_success'), $result, success());
    }

    public
    function boxDetails(BoxDetailsRequest $request)
    {
        $data = $request->validated();
        $box = Box::where('id', $data['id'])->orderBy('id', 'asc')->first();
        $result['box'] = new BoxResource($box);
        $result['categories'] = CategoryResource::collection(BoxCategory::where('box_id', $data['id'])->get());
        return msgdata(true, trans('lang.data_display_success'), $result, success());
    }

}

