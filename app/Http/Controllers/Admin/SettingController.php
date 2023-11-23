<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\SettingRequest;
use App\Models\Gift;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SettingController extends Controller
{
    public function permission()
    {
        return auth()->guard('admin')->user()->can('settings');
    }


    public function index()
    {
        if (!$this->permission()) return "Not Authorized";
        $results = Setting::whereNotIn('key', ['accessKey', 'app_gif'])->get();

        return view('Admin.settings.index', compact('results'));
    }

    public function datatable()
    {
        if (!$this->permission()) return "Not Authorized";

        $auth = Auth::guard('admin')->user();
        $model = Setting::query();
        $model = $model->whereNotIn('key', ['accessKey', 'app_gif']);
        return DataTables::eloquent($model)
            ->addIndexColumn()
            ->editColumn('key', function ($row) {
                return trans('lang.' . $row->key);
            })
            ->editColumn('image', function ($row) {
                return '<a class="symbol symbol-50px"><span class="symbol-label" style="background-image:url(' . $row->image . ');"></span></a>';
            })
            ->addColumn('actions', function ($row) use ($auth) {
                $buttons = '';
                $buttons .= '<a href="' . route('settings.edit', [$row->id]) . '" class="btn btn-primary btn-circle btn-sm m-1" title="' . trans('lang.edit') . '">
                            <i class="fa fa-edit"></i>
                        </a>';

                return $buttons;
            })
            ->
            rawColumns(['actions', 'image'])
            ->make();

    }

    public function edit($id)
    {
        if (!$this->permission()) return "Not Authorized";
        $row = Setting::whereId($id)->first();

        return view('Admin.settings.edit', compact('row'));
    }

    public function update(SettingRequest $request, $id)
    {
        if (!$this->permission()) return "Not Authorized";

        $data = $request->validated();
        if (isset($data['image'])) {
            if (is_file($data['image'])) {
                $img_name = 'setting_' . time() . random_int(0000, 9999) . '.' . $data['image']->getClientOriginalExtension();
                $data['image']->move(public_path('/uploads/setting/'), $img_name);
                $data['image'] = $img_name;
            }
        }
        Setting::whereId($id)->update($data);
        session()->flash('success', 'تم التعديل بنجاح');
        return redirect()->route('settings.index');
    }


}
