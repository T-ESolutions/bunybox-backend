<?php

namespace App\Http\Controllers\Admin;

use App\Models\Box;
use App\Models\BoxCategory;
use App\Models\BoxProduct;
use App\Models\Category;
use App\Models\MainCategory;
use App\Models\Product;
use Grimzy\LaravelMysqlSpatial\Types\LineString;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Grimzy\LaravelMysqlSpatial\Types\Polygon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class OfferController extends Controller
{

    //for products
    public function index()
    {
        $results = Box::latest()->paginate(config('default_pagination'));
        return view('Admin.offers.index', compact('results'));
    }

    public function getData()
    {
        $auth = Auth::guard('admin')->user();
        $model = Box::query();
        $model->where('is_offer',1);
        return DataTables::eloquent($model)
            ->addIndexColumn()
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
                    $category  = $row->mainCategory->title_ar;
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
                $buttons .= '<a href="' . route('offers.edit', [$row->id]) . '" class="btn btn-primary btn-circle btn-sm m-1" title="'.trans('lang.edit').'">
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
            ->rawColumns(['actions', 'image','main_category_id','checkbox'])
            ->make();

    }

    public function table_buttons()
    {
        return view('Admin.offers.button');
    }

    public function create()
    {
//        $main_categories = MainCategory::get();
//        $categories = Category::get();
        $products = Product::orderBy('category_id')->get();
        return view('Admin.offers.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'main_category_id' => 'required|exists:main_categories,id',
            'title_ar' => 'required|string',
            'title_en' => 'required|string',
            'desc_ar' => 'required|string',
            'desc_en' => 'required|string',
//            'price' => 'required|numeric',
//            'min_price' => 'required|numeric',
//            'max_price' => 'required|numeric',
            'offer_price' => 'required|numeric',
            'offer_end_time' => 'required|',
            'image' => 'required|',
        ]);

        $row = new Box();
        $row->main_category_id = MainCategory::first()->id;
        $row->title_ar = $request->title_ar;
        $row->title_en = $request->title_en;
        $row->desc_ar = $request->desc_ar;
        $row->desc_en = $request->desc_en;
        $row->price = 0;
        $row->min_price = 0;
        $row->max_price = 0;
        $row->is_offer = 1;
        $row->offer_price = $request->offer_price;
        $row->offer_end_time = $request->offer_end_time;
        $row->image = $request->image;
        $row->save();
        foreach ($request->product_id as $product_id){
            $boxProduct = new BoxProduct();
            $row->product_id = $product_id;
            $row->box_id = $row->id;
            $boxProduct->save();
        }

        return redirect()->back()->with('message', trans('lang.added_s'));
    }

    public function edit($id)
    {
        $products = Product::orderBy('category_id')->get();
        $boxProducts = BoxProduct::whereBoxId($id)->pluck('product_id')->toArray();

        $row = Box::findOrFail($id);
        return view('Admin.offers.edit', compact('row','products','boxProducts'));
    }

    public function update(Request $request, $id)
    {
        $row = Box::findOrFail($id);

        $request->validate([
            'main_category_id' => 'required|exists:main_categories,id',
            'title_ar' => 'required|string',
            'title_en' => 'required|string',
            'desc_ar' => 'required|string',
            'desc_en' => 'required|string',
            'offer_price' => 'required|numeric',
            'offer_end_time' => 'required|',
            'image' => 'sometimes',
        ]);

        $row->main_category_id = MainCategory::first()->id;
        $row->title_ar = $request->title_ar;
        $row->title_en = $request->title_en;
        $row->desc_ar = $request->desc_ar;
        $row->desc_en = $request->desc_en;
        $row->price = 0;
        $row->min_price = 0;
        $row->max_price = 0;
        $row->is_offer = 1;
        $row->offer_price = $request->offer_price;
        $row->offer_end_time = $request->offer_end_time;
        $row->image = $request->image;
        $row->save();

        BoxProduct::whereBoxId($id)->delete();
        foreach ($request->product_id as $product_id){
            BoxProduct::create([
                'product_id' => $product_id,
                'box_id' => $row->id,
            ]);
        }
        return redirect()->back()->with('message', trans('lang.updated_s'));
//        return redirect()->route('admin.settings.offers');
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
            Box::whereIn('id', $request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed']);
        }
        return response()->json(['message' => 'Success']);
    }
}
