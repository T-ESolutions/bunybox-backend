<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\SettingRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SettingController extends Controller
{
    public function index()
    {
        $data = Setting::whereNotIn('key', ['logo_ar', 'logo_en', 'fav_icon'])->get();
        return view('Admin.settings.settings', compact('data'));
    }

    public function update(SettingRequest $request)
    {
        $inputs = $request->validated();
        Setting::setMany($inputs);
        session()->flash('success', 'تم التعديل بنجاح');
        return back();
    }


}
