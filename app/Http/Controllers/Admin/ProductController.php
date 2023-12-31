<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Product;
use Grimzy\LaravelMysqlSpatial\Types\LineString;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Grimzy\LaravelMysqlSpatial\Types\Polygon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function permission()
    {
        return auth()->guard('admin')->user()->can('products');
    }

    //for products
    public function index()
    {
        if (!$this->permission()) return "Not Authorized";

        $results = Product::latest()->paginate(config('default_pagination'));
        return view('Admin.products.index', compact('results'));
    }

    public function getData()
    {
        if (!$this->permission()) return "Not Authorized";

        $auth = Auth::guard('admin')->user();
        $model = Product::query();

        return DataTables::eloquent($model)
            ->addIndexColumn()
            ->addColumn('active', 'Admin.products.active_btn')
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
            ->editColumn('category_id', function ($row) {
                if ($row->category) {
                    $category = $row->category->title;
                    return "<b class='badge badge-success'>$category</b>";
                } else {
                    return "-";
                }
            })
            ->addColumn('actions', function ($row) use ($auth) {
                $buttons = '';
                $buttons .= '<a href="' . route('products.edit', [$row->id]) . '" class="btn btn-primary btn-circle btn-sm m-1" title="' . trans('lang.edit') . '">
                            <i class="fa fa-edit"></i>
                        </a>';

                return $buttons;
            })
            ->rawColumns(['actions', 'active', 'image', 'category_id', 'checkbox'])
            ->make();

    }

    public function table_buttons()
    {
        return view('Admin.products.button');
    }

    public function create()
    {
        if (!$this->permission()) return "Not Authorized";

        $categories = Category::all();
        return view('Admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        if (!$this->permission()) return "Not Authorized";

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title_ar' => 'required|string',
            'title_en' => 'required|string',
            'desc_ar' => 'required|string',
            'desc_en' => 'required|string',
            'quantity' => 'required|numeric',
            'buy_price' => 'required|numeric',
            'sel_price' => 'required|numeric',
            'shoes_size' => 'nullable|numeric',
            'size' => 'nullable|in:S,L,XL,FS',
            'min_age' => 'nullable|numeric',
            'max_age' => 'nullable|numeric',
            'min_weight' => 'nullable|numeric',
            'max_weight' => 'nullable|numeric',
            'min_height' => 'nullable|numeric',
            'max_height' => 'nullable|numeric',
            'image' => 'required|image',
        ]);

        $row = new Product();
        $row->category_id = $request->category_id;
        $row->title_ar = $request->title_ar;
        $row->title_en = $request->title_en;
        $row->desc_ar = $request->desc_ar;
        $row->desc_en = $request->desc_en;
        $row->quantity = $request->quantity;
        $row->buy_price = $request->buy_price;
        $row->sel_price = $request->sel_price;
        $row->shoes_size = $request->shoes_size;
        $row->size = $request->size;
        $row->min_age = $request->min_age;
        $row->max_age = $request->max_age;
        $row->min_weight = $request->min_weight;
        $row->max_weight = $request->max_weight;
        $row->min_height = $request->min_height;
        $row->max_height = $request->max_height;
        $row->image = $request->image;
        $row->save();
        return redirect()->back()->with('message', trans('lang.added_s'));
    }

    public function edit($id)
    {
        if (!$this->permission()) return "Not Authorized";

        $categories = Category::all();
        $row = Product::findOrFail($id);
        return view('Admin.products.edit', compact('row', 'categories'));
    }

    public function update(Request $request, $id)
    {
        if (!$this->permission()) return "Not Authorized";

        $row = Product::findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title_ar' => 'required|string',
            'title_en' => 'required|string',
            'desc_ar' => 'required|string',
            'desc_en' => 'required|string',
            'quantity' => 'required|numeric',
            'buy_price' => 'required|numeric',
            'sel_price' => 'required|numeric',
            'shoes_size' => 'nullable|numeric',
            'size' => 'nullable|in:S,L,XL,FS',
            'min_age' => 'nullable|numeric',
            'max_age' => 'nullable|numeric',
            'min_weight' => 'nullable|numeric',
            'max_weight' => 'nullable|numeric',
            'min_height' => 'nullable|numeric',
            'max_height' => 'nullable|numeric',
            'image' => 'nullable|image',
        ]);

        $row->category_id = $request->category_id;
        $row->title_ar = $request->title_ar;
        $row->title_en = $request->title_en;
        $row->desc_ar = $request->desc_ar;
        $row->desc_en = $request->desc_en;
        $row->quantity = $request->quantity;
        $row->buy_price = $request->buy_price;
        $row->sel_price = $request->sel_price;
        $row->shoes_size = $request->shoes_size;
        $row->size = $request->size;
        $row->min_age = $request->min_age;
        $row->max_age = $request->max_age;
        $row->min_weight = $request->min_weight;
        $row->max_weight = $request->max_weight;
        $row->min_height = $request->min_height;
        $row->max_height = $request->max_height;
        if ($request->image != null) {
            $row->image = $request->image;
        }

        $row->save();
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
        try {
            Product::whereIn('id', $request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed']);
        }
        return response()->json(['message' => 'Success']);
    }

    public function changeActive(Request $request)
    {
        $box = Product::where('id', $request->id)->first();
        if ($box->active == 0)
            Product::where('id', $request->id)->update(['active' => 1]);
        else
            Product::where('id', $request->id)->update(['active' => 0]);
        return 1;
    }

}
