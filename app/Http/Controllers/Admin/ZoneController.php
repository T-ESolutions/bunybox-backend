<?php

namespace App\Http\Controllers\Admin;

use App\Models\Zone;
use Grimzy\LaravelMysqlSpatial\Types\LineString;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Grimzy\LaravelMysqlSpatial\Types\Polygon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ZoneController extends Controller
{

    //for zones
    public function index()
    {
        $zones = Zone::latest()->paginate(config('default_pagination'));
        return view('admin.zones.index', compact('zones'));
    }

    public function getData()
    {
        $auth = Auth::guard('admin')->user();
        $model = Zone::query();

        return DataTables::eloquent($model)
            ->addIndexColumn()
            ->editColumn('image', function ($row) {
                return '<a class="symbol symbol-50px"><span class="symbol-label" style="background-image:url(' . $row->image . ');"></span></a>';
            })
            ->editColumn('status', function ($row) {
                if ($row->status == 1) {
                    return "<b class='badge badge-success'>مفعل</b>";
                } else {
                    return "<b class='badge badge-danger'>غير مفعل</b>";
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
                $buttons .= '<a href="' . route('zones.edit', [$row->id]) . '" class="btn btn-primary btn-circle btn-sm m-1" title="'.trans('lang.edit').'">
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
            ->rawColumns(['actions', 'status', 'image'])
            ->make();

    }

    public function get_all_zone_cordinates($id = 0)
    {
        $zones = Zone::where('id', '<>', $id)->active()->get();
        $data = [];
        foreach ($zones as $zone) {
            $data[] = format_coordiantes($zone->coordinates[0]);
        }
        return response()->json($data, 200);
    }

    public function search(Request $request)
    {
        $key = explode(' ', $request['search']);
        $zones = Zone::where(function ($q) use ($key) {
            foreach ($key as $value) {
                $q->orWhere('name', 'like', "%{$value}%");
            }
        })->limit(50)->get();
        return response()->json([
            'view' => view('admin-views.zone.partials._table', compact('zones'))->render(),
            'total' => $zones->count()
        ]);
    }

    public function create()
    {
        return view('admin.zones.create');
    }
//
//    public function store(Request $request)
//    {
//        $request->validate([
//            'name' => 'required|unique:zones,name|max:191',
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
//        $zone_id=Zone::all()->count() + 1;
//        $polygon[] = new Point($lastcord[0], $lastcord[1]);
//        $zone = new Zone();
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
            'name' => 'required|unique:zones,name',
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
        $zone_id = Zone::all()->count() + 1;
        $polygon[] = new Point($lastcord[0], $lastcord[1]);
        $zone = new Zone();
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
        $zone = Zone::selectRaw("*,ST_AsText(ST_Centroid(`coordinates`)) as center")->findOrFail($id);
        return view('admin.zones.edit', compact('zone'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:zones,name,' . $id,
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
        $zone = Zone::findOrFail($id);
        $zone->name = $request->name;
        $zone->coordinates = new Polygon([new LineString($polygon)]);
        $zone->restaurant_wise_topic = 'zone_' . $id . '_restaurant';
        $zone->customer_wise_topic = 'zone_' . $id . '_customer';
        $zone->deliveryman_wise_topic = 'zone_' . $id . '_delivery_man';
        $zone->save();
        session()->flash('success', 'تم التعديل بنجاح');
        return redirect()->back();
//        return redirect()->route('admin.settings.zones');
    }

}
