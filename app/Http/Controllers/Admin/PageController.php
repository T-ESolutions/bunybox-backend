<?php

namespace App\Http\Controllers\Admin;

use App\Models\MealType;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PageController extends Controller
{
    public function permission()
    {
        return (auth()->guard('admin')->user()->can('privacy') ||
            auth()->guard('admin')->user()->can('terms') ||
            auth()->guard('admin')->user()->can('about_us'));
    }

    public function edit($type)
    {
        if (!$this->permission()) return "Not Authorized";

        $row = Page::where('type', $type)->first();
        if (!$row) {
            session()->flash('error_message', 'الحقل غير موجود');
            return redirect()->back();
        }
        return view('Admin.pages.edit', compact('row', 'type'));
    }

    public function update(Request $request)
    {
        if (!$this->permission()) return "Not Authorized";

        $validator = Validator::make($request->all(), [
            'row_id' => 'required|exists:pages,id',
            'type' => 'required|in:about_us,terms,privacy',
            'title_ar' => 'required',
            'title_en' => 'required',
            'image' => 'nullable|image|mimes:png,jpg,jpeg',
        ]);
        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $row = Page::whereId($request->row_id)->first();
        $row->update($request->except('row_id', '_token', 'image'));
        if ($request->has('image') && is_file($request->image)) {
            $row->update(['image' => $request->image]);
        }
        $row->save();

        session()->flash('message', 'تم التعديل بنجاح');
        return redirect()->route('pages.edit', [$request->type]);
    }

}
