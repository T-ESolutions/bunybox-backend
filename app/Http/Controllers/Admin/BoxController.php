<?php

namespace App\Http\Controllers\Admin;

use App\Models\Box;
use App\Models\BoxCategory;
use App\Models\Category;
use App\Models\MainCategory;
use Grimzy\LaravelMysqlSpatial\Types\LineString;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Grimzy\LaravelMysqlSpatial\Types\Polygon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class BoxController extends Controller
{
    public function permission()
    {
        return auth()->guard('admin')->user()->can('boxes');
    }

    public function index()
    {
        if (!$this->permission()) return "Not Authorized";

        $results = Box::latest()->paginate(config('default_pagination'));
        return view('Admin.boxes.index', compact('results'));
    }

    public function getData()
    {
        if (!$this->permission()) return "Not Authorized";

        $model = Box::query();
        $model->where('is_offer', 0);
        return DataTables::eloquent($model)
            ->addIndexColumn()
            ->addColumn('active', 'Admin.boxes.active_btn')
            ->addColumn('checkbox', function ($row) {
                $checkbox = '';
                $checkbox .= '<div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input selector checkbox" type="checkbox" value="' . $row->id . '" />
                                </div>';
                return $checkbox;
            })
            ->editColumn('image', function ($row) {
                return '<a class="symbol symbol-50px"><span class="symbol-label" style="background-image:url(' . $row->image . ');"></span></a>';
            })
            ->editColumn('main_category_id', function ($row) {
                if ($row->mainCategory) {
                    $category = $row->mainCategory->title_ar;
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
            ->addColumn('actions', function ($row) {
                $buttons = '';
//                if ($auth->can('sliders.update')) {
                $buttons .= '<a href="' . route('boxes.edit', [$row->id]) . '" class="btn btn-primary btn-circle btn-sm m-1" title="' . trans('lang.edit') . '">
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
            ->rawColumns(['actions', 'active', 'checkbox', 'image', 'main_category_id'])
            ->make();

    }

    public function table_buttons()
    {
        return view('Admin.boxes.button');
    }

    public function create()
    {
        if (!$this->permission()) return "Not Authorized";

        $main_categories = MainCategory::get();
        $categories = Category::get();
        return view('Admin.boxes.create', compact('main_categories', 'categories'));
    }

    public function store(Request $request)
    {
        if (!$this->permission()) return "Not Authorized";

        $request->validate([
            'main_category_id' => 'required|exists:main_categories,id',
            'title_ar' => 'required|string',
            'title_en' => 'required|string',
            'desc_ar' => 'required|string',
            'desc_en' => 'required|string',
            'price' => 'required|numeric',
            'min_price' => 'required|numeric',
            'max_price' => 'required|numeric',
            'image' => 'required|',
            'category_id' => 'required|Array',
        ]);

        $row = new Box();
        $row->main_category_id = $request->main_category_id;
        $row->title_ar = $request->title_ar;
        $row->title_en = $request->title_en;
        $row->desc_ar = $request->desc_ar;
        $row->desc_en = $request->desc_en;
        $row->price = $request->price;
        $row->min_price = $request->min_price;
        $row->max_price = $request->max_price;
        $row->is_offer = 0;
        $row->offer_price = 0;
        $row->offer_end_time = null;
        $row->image = $request->image;
        $row->save();
        foreach ($request->category_id as $category_id) {
            $boxCategory = new BoxCategory();
            $row->category_id = $category_id;
            $row->box_id = $row->id;
            $boxCategory->save();
        }


        return redirect()->back()->with('message', trans('lang.added_s'));
    }

    public function edit($id)
    {
        if (!$this->permission()) return "Not Authorized";

        $main_categories = MainCategory::get();
        $categories = Category::get();
        $boxCategories = BoxCategory::whereBoxId($id)->pluck('category_id')->toArray();
        $row = Box::findOrFail($id);
        return view('Admin.boxes.edit', compact('row', 'main_categories', 'categories', 'boxCategories'));
    }

    public function update(Request $request, $id)
    {
        if (!$this->permission()) return "Not Authorized";

        $row = Box::findOrFail($id);

        $request->validate([
            'main_category_id' => 'required|exists:main_categories,id',
            'title_ar' => 'required|string',
            'title_en' => 'required|string',
            'desc_ar' => 'required|string',
            'desc_en' => 'required|string',
            'price' => 'required|numeric',
            'min_price' => 'required|numeric',
            'max_price' => 'required|numeric',
            'image' => 'nullable|image',
            'category_id' => 'required|Array',
        ]);

        $row->main_category_id = $request->main_category_id;
        $row->title_ar = $request->title_ar;
        $row->title_en = $request->title_en;
        $row->desc_ar = $request->desc_ar;
        $row->desc_en = $request->desc_en;
        $row->price = $request->price;
        $row->min_price = $request->min_price;
        $row->max_price = $request->max_price;
        $row->is_offer = 0;
        $row->offer_price = 0;
        $row->offer_end_time = null;
        if ($request->image != null) {
            $row->image = $request->image;
        }
        $row->save();

        BoxCategory::whereBoxId($id)->delete();
        foreach ($request->category_id as $category_id) {
            BoxCategory::create([
                'category_id' => $category_id,
                'box_id' => $row->id,
            ]);
        }
        return redirect()->back()->with('message', trans('lang.updated_s'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        if (!$this->permission()) return "Not Authorized";

        try {
            Box::whereIn('id', $request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed']);
        }
        return response()->json(['message' => 'Success']);
    }

    public function changeActive(Request $request)
    {
        $box = Box::where('id', $request->id)->first();
        if ($box->active == 0)
            Box::where('id', $request->id)->update(['active' => 1]);
        else
            Box::where('id', $request->id)->update(['active' => 0]);
        return 1;
    }
}
