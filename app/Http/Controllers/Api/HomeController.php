<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\SaveSizesDataRequest;
use App\Http\Requests\Api\User\UserRequest;
use App\Http\Resources\Api\User\MainCategoryResource;
use App\Models\MainCategory;
use App\Models\Setting;
use App\Models\User;


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
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function home()
    {
        $slider_image = Setting::where('key', 'slider_image')->first();
        $data['slider']= $slider_image->image ;
        $data['main_categories']= MainCategoryResource::collection(MainCategory::orderBy('id','asc')->get()) ;
        return msgdata(true, trans('lang.data_display_success'), $data, success());
    }

    public function saveSizesData(SaveSizesDataRequest $request)
    {
        $data = $request->validated();
        $user = User::create($data);
        //sending otp to user
        $phone = $data['country_code'] . '' . $data['phone'];
        $otp = \Otp::generate($phone);
        if (env('APP_ENV') == 'local') {
            $otp = "9999";
        }
        $result['otp'] = $otp;

        return msgdata(true, trans('lang.sign_up_success'), $result, success());
    }

}

