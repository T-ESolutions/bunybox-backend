<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\User\PagesResources;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function settings(Request $request)
    {
        $settings = Setting::get();
//        $screens = (ScreenResources::collection($screens));
        return msgdata(true , trans('lang.success') , $settings , success() );

    }

    public function custom_settings(Request $request, $key)
    {
//        if($request->header('lang')){
//            $key = $key . '_' . $request->header('lang');
//        }

        $setting = Setting::where('key', $key)->first();
        if(!$setting){
            return msg(false, trans('lang.page_not_found'), failed());

        }
        $result['result'] = $setting->value;
        return msgdata(true , trans('lang.success') , $result , success() );

    }



    public function pages(Request $request, $type)
    {
        $page = Page::where('type', $type)->first();
        if (!$page) {
            return msg(false, trans('lang.page_not_found'), failed());
        }
        $data = new PagesResources($page);
        return msgdata(true , trans('lang.success') , $data , success() );
    }
}
