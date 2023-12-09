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
use App\Http\Resources\Api\User\OffersResource;
use App\Models\Box;
use App\Models\BoxCategory;
use App\Models\MainCategory;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class OffersController extends Controller
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

    public function offers()
    {
        $offers = Box::whereHas('offer_products')->with('offer_products')->where('is_offer',1)->where('offer_end_time', '>',Carbon::now())->paginate(10);

        $offers = OffersResource::collection($offers)->response()->getData();
        return msgdata(true, trans('lang.data_display_success'), $offers, success());
    }

}

