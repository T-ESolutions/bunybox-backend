<?php

namespace App\Http\Controllers\Admin;

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

    //for products
    public function index()
    {
        $results = Product::latest()->paginate(config('default_pagination'));
        return view('Admin.products.index', compact('results'));
    }

    public function getData()
    {
        $auth = Auth::guard('admin')->user();
        $model = Product::query();

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
                $buttons .= '<a href="' . route('products.edit', [$row->id]) . '" class="btn btn-primary btn-circle btn-sm m-1" title="'.trans('lang.edit').'">
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
            ->rawColumns(['actions', 'image','category_id'])
            ->make();

    }

    public function get_all_zone_cordinates($id = 0)
    {
        $products = Product::where('id', '<>', $id)->active()->get();
        $data = [];
        foreach ($products as $zone) {
            $data[] = format_coordiantes($zone->coordinates[0]);
        }
        return response()->json($data, 200);
    }

    public function search(Request $request)
    {
        $key = explode(' ', $request['search']);
        $products = Product::where(function ($q) use ($key) {
            foreach ($key as $value) {
                $q->orWhere('name', 'like', "%{$value}%");
            }
        })->limit(50)->get();
        return response()->json([
            'view' => view('admin-views.zone.partials._table', compact('products'))->render(),
            'total' => $products->count()
        ]);
    }

    public function create()
    {
        return view('Admin.products.create');
    }
//
//    public function store(Request $request)
//    {
//        $request->validate([
//            'name' => 'required|unique:products,name|max:191',
//            'coordinates' => 'required',
//        ]);
//
//        $value = $request->coordinates;
//        foreach(explode('),(',trim($value,'()')) as $index=>$single_array){
//            if($index == 0)
//            {
//                $lastcord = explode(',',$single_array);
//            }
//            $coords = explode(',',$single_array);
//            $polygon[] = new Point($coords[0], $coords[1]);
//        }
//        $zone_id=Product::all()->count() + 1;
//        $polygon[] = new Point($lastcord[0], $lastcord[1]);
//        $zone = new Product();
//        $zone->name = $request->name;
//        $zone->coordinates = new Polygon([new LineString($polygon)]);
//        $zone->restaurant_wise_topic =  'zone_'.$zone_id.'_restaurant';
//        $zone->customer_wise_topic = 'zone_'.$zone_id.'_customer';
//        $zone->deliveryman_wise_topic = 'zone_'.$zone_id.'_delivery_man';
//        $zone->save();
//
//        session()->flash('success', 'تم الإضافة بنجاح');
//        return back();
//    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:products,name',
            'coordinates' => 'required',
        ]);

        $value = $request->coordinates;
        foreach (explode('),(', trim($value, '()')) as $index => $single_array) {
            if ($index == 0) {
                $lastcord = explode(',', $single_array);
            }
            $coords = explode(',', $single_array);
            $polygon[] = new Point($coords[0], $coords[1]);
        }
        $zone_id = Product::all()->count() + 1;
        $polygon[] = new Point($lastcord[0], $lastcord[1]);
        $zone = new Product();
        $zone->name = $request->name;
        $zone->coordinates = new Polygon([new LineString($polygon)]);
//        $zone->restaurant_wise_topic = 'zone_' . $zone_id . '_restaurant';
//        $zone->customer_wise_topic = 'zone_' . $zone_id . '_customer';
//        $zone->deliveryman_wise_topic = 'zone_' . $zone_id . '_delivery_man';
        $zone->save();

        session()->flash('success', 'تم الإضافة بنجاح');
        return back();
    }

    public function edit($id)
    {
        if (env('APP_MODE') == 'demo' && $id == 1) {
            session()->flash('warning', 'آسف! لا يمكنك تحرير هذه المنطقة. الرجاء إضافة منطقة جديدة للتعديل');
            return back();
        }
        $zone = Product::selectRaw("*,ST_AsText(ST_Centroid(`coordinates`)) as center")->findOrFail($id);
        return view('Admin.products.edit', compact('zone'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:products,name,' . $id,
            'coordinates' => 'required',
        ]);
        $value = $request->coordinates;
        foreach (explode('),(', trim($value, '()')) as $index => $single_array) {
            if ($index == 0) {
                $lastcord = explode(',', $single_array);
            }
            $coords = explode(',', $single_array);
            $polygon[] = new Point($coords[0], $coords[1]);
        }
        $polygon[] = new Point($lastcord[0], $lastcord[1]);
        $zone = Product::findOrFail($id);
        $zone->name = $request->name;
        $zone->coordinates = new Polygon([new LineString($polygon)]);
        $zone->restaurant_wise_topic = 'zone_' . $id . '_restaurant';
        $zone->customer_wise_topic = 'zone_' . $id . '_customer';
        $zone->deliveryman_wise_topic = 'zone_' . $id . '_delivery_man';
        $zone->save();
        session()->flash('success', 'تم التعديل بنجاح');
        return redirect()->back();
//        return redirect()->route('admin.settings.products');
    }

}
