<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\BoxDetailsRequest;
use App\Http\Requests\Api\User\SaveSizesDataRequest;
use App\Http\Requests\Api\User\UserRequest;
use App\Http\Resources\Api\User\BoxCategoriesFinalResource;
use App\Http\Resources\Api\User\BoxFinalResource;
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


    public function saveSizesDataBox(SaveSizesDataRequest $request, $id)
    {
        $data = $request->validated();
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

   

}

