<?php

namespace App\Http\Controllers\Admin;

use App\Models\MainCategory;
use Grimzy\LaravelMysqlSpatial\Types\LineString;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Grimzy\LaravelMysqlSpatial\Types\Polygon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class MainCategoryController extends Controller
{
    public function permission(){
        return auth()->guard('admin')->user()->can('main_categories');
    }

    //for products
    public function index()
    {
        if(!$this->permission()) return "Not Authorized";

        $results = MainCategory::latest()->paginate(config('default_pagination'));
        return view('Admin.main_categories.index', compact('results'));
    }

    public function getData()
    {
        if(!$this->permission()) return "Not Authorized";

        $auth = Auth::guard('admin')->user();
        $model = MainCategory::query();

        return DataTables::eloquent($model)
            ->addIndexColumn()
            ->editColumn('image', function ($row) {
                return '<a class="symbol symbol-50px"><span class="symbol-label" style="background-image:url(' . $row->image . ');"></span></a>';
            })
            ->editColumn('category_id', function ($row) {
                if ($row->category) {
                    $category  = $row->category->title_ar;
                    return "<b class='badge badge-success'>$category</b>";
                } else {
                    return "-";
                }
            })
//            ->addColumn('select',function ($row){
//                return '<div class="form-check form-check-sm form-check-custom form-check-solid me-3">
//                                        <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_ecommerce_products_table .form-check-input" value="'.$row->id.'" />
//                                    </div>';
//            })
            ->addColumn('actions', function ($row) use ($auth) {
                $buttons = '';
//                if ($auth->can('sliders.update')) {
                $buttons .= '<a href="' . route('main_categories.edit', [$row->id]) . '" class="btn btn-primary btn-circle btn-sm m-1" title="'.trans('lang.edit').'">
                            <i class="fa fa-edit"></i>
                        </a>';
//                }
//                if ($auth->can('sliders.delete')) {
//                $buttons .= '<a class="btn btn-danger btn-sm delete btn-circle m-1" data-id="' . $row->id . '"  title="حذف">
//                            <i class="fa fa-trash"></i>
//                        </a>';
//                }
                return $buttons;
            })
            ->rawColumns(['actions', 'image'])
            ->make();

    }



    public function create()
    {
        if(!$this->permission()) return "Not Authorized";

        return view('Admin.main_categories.create');
    }

    public function store(Request $request)
    {
        if(!$this->permission()) return "Not Authorized";

        $request->validate([
            'title_ar' => 'required|string',
            'title_en' => 'required|string',
            'desc_ar' => 'required|string',
            'desc_en' => 'required|string',
            'image' => 'required|',
        ]);

        $row = new MainCategory();
        $row->title_ar = $request->title_ar;
        $row->title_en = $request->title_en;
        $row->desc_ar = $request->desc_ar;
        $row->desc_en = $request->desc_en;
        $row->image = $request->image;
        $row->save();
        return redirect()->back()->with('message', trans('lang.added_s'));
    }

    public function edit($id)
    {
        if(!$this->permission()) return "Not Authorized";

        $row = MainCategory::findOrFail($id);
        return view('Admin.main_categories.edit', compact('row'));
    }

    public function update(Request $request, $id)
    {
        if(!$this->permission()) return "Not Authorized";

        $row = MainCategory::findOrFail($id);

        $request->validate([
            'title_ar' => 'required|string',
            'title_en' => 'required|string',
            'desc_ar' => 'required|string',
            'desc_en' => 'required|string',
            'image' => 'required|',
        ]);

        $row->title_ar = $request->title_ar;
        $row->title_en = $request->title_en;
        $row->desc_ar = $request->desc_ar;
        $row->desc_en = $request->desc_en;
        $row->image = $request->image;
        $row->save();
        return redirect()->back()->with('message', trans('lang.added_s'));
    }

}
