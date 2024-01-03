<?php

namespace App\Http\Controllers\Admin;

use App\Models\Box;
use App\Models\BoxCategory;
use App\Models\Gift;
use App\Models\GiftBox;
use App\Models\Category;
use App\Models\GiftMainCategory;
use App\Models\GiftMoneyDetail;
use App\Models\MainCategory;
use Grimzy\LaravelMysqlSpatial\Types\LineString;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Grimzy\LaravelMysqlSpatial\Types\Polygon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class GiftController extends Controller
{
    public function permission()
    {
        return auth()->guard('admin')->user()->can('gifts');
    }

    public function index()
    {
        if (!$this->permission()) return "Not Authorized";

        $results = Gift::latest()->paginate(config('default_pagination'));
        return view('Admin.gifts.index', compact('results'));
    }

    public function getData()
    {
        if (!$this->permission()) return "Not Authorized";

        $auth = Auth::guard('admin')->user();
        $model = Gift::query();
        return DataTables::eloquent($model)
            ->addIndexColumn()
            ->addColumn('active', 'Admin.gifts.active_btn')
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
            ->editColumn('type', function ($row) {
                if ($row->type == 'product')
                    return '<b class="badge badge-success">' . trans('lang.' . $row->type) . '</b>';
                else
                    return '<b class="badge badge-info">' . trans('lang.' . $row->type) . '</b>';
            })
            ->addColumn('boxes', function ($row) {
                $res = '';
                if ($row->boxes) {
                    foreach ($row->boxes as $box) {
                        $res .= '<b class="badge badge-success">' . $box->title . '</b><br>';
                    }
                    return $res;
                } else {
                    return '-';
                }
            })
            ->addColumn('main_cats', function ($row) {
                $res2 = '';
                if ($row->mainCats) {
                    foreach ($row->mainCats as $mainCat) {
                        $main_category_ar = $mainCat->main_category_ar;
                        $res2 .= '<b class="badge badge-info">' . $main_category_ar . '</b><br>';
                    }
                    return $res2;
                } else {
                    return '-';
                }
            })
            ->addColumn('details', function ($row) {
                if ($row->type == 'money') {
                    $buttons = '';
                    $buttons .= '<a href="' . route('gifts.show', [$row->id]) . '" class="btn btn-warning btn-circle btn-sm m-1"
                 title="' . trans('lang.details') . '">
                            <i class="fa fa-eye"></i>
                        </a>';
                } else {
                    $buttons = '';
                }
                return $buttons;
            })
            ->addColumn('actions', function ($row) use ($auth) {
                $buttons = '';
                $buttons .= '<a href="' . route('gifts.edit', [$row->id]) . '" class="btn btn-primary btn-circle btn-sm m-1" title="' . trans('lang.edit') . '">
                            <i class="fa fa-edit"></i>
                        </a>';
                return $buttons;
            })
            ->
            rawColumns(['actions', 'active', 'checkbox', 'image', 'type', 'boxes', 'main_cats', 'details'])
            ->make();

    }

  public function giftMoneyDetailsDatatable($id)
    {
        if (!$this->permission()) return "Not Authorized";

        $auth = Auth::guard('admin')->user();
        $model = GiftMoneyDetail::query();
        $model = $model->where('gift_id',$id);
        return DataTables::eloquent($model)
            ->addIndexColumn()
//            ->addColumn('checkbox', function ($row) {
//                $checkbox = '';
//                $checkbox .= '<div class="form-check form-check-sm form-check-custom form-check-solid">
//                                    <input class="form-check-input selector checkbox" type="checkbox" value="' . $row->id . '" />
//                                </div>';
//                return $checkbox;
//            })

            ->editColumn('is_selected', function ($row) {
                if ($row->is_selected)
                    return '<b class="badge badge-danger">' . trans('lang.selected') . '</b>';
                else
                    return '<b class="badge badge-success">' . trans('lang.not_selected') . '</b>';
            })

//            ->addColumn('actions', function ($row) use ($auth) {
//                $buttons = '';
//                $buttons .= '<a href="' . route('gifts.edit', [$row->id]) . '" class="btn btn-primary btn-circle btn-sm m-1" title="' . trans('lang.edit') . '">
//                            <i class="fa fa-edit"></i>
//                        </a>';
//                return $buttons;
//            })
            ->
            rawColumns(['actions', 'active', 'checkbox', 'image', 'type', 'boxes', 'main_cats', 'details','is_selected'])
            ->make();

    }

    public function table_buttons()
    {
        return view('Admin.gifts.button');
    }

    public function create()
    {
        if (!$this->permission()) return "Not Authorized";

        $main_categories = MainCategory::all();
        $boxs = Box::all();

        return view('Admin.gifts.create', compact('boxs', 'main_categories'));
    }

    public function store(Request $request)
    {
        if (!$this->permission()) return "Not Authorized";

        $request->validate([
            'main_category_id' => 'required_if:type,product|array',
            'box_id' => 'required_if:type,product|array',
            'title_ar' => 'required|string',
            'title_en' => 'required|string',
            'money_amount' => 'required_if:type,money',
            'num_of_gifts' => 'required_if:type,money',
            'type' => 'required|in:product,money',
            'image' => 'required|image',
        ]);

        $row = new Gift();
        $row->title_ar = $request->title_ar;
        $row->title_en = $request->title_en;
        $row->money_amount = $request->type == 'product' ? 0 : $request->money_amount;
        $row->money_out = 0;
        $row->money_remain = $request->type == 'product' ? 0 : $request->money_amount;
        $row->type = $request->type;
        $row->image = $request->image;
        $row->save();

        //$request->type == 'money'
        if ($request->type == 'money') {
            $divided = $request->money_amount / $request->num_of_gifts;
            for ($i = 0; $i < $request->num_of_gifts; $i++) {
                GiftMoneyDetail::create([
                    'gift_id' => $row->id,
                    'amount' => $divided,
                    'is_selected' => 0,
                ]);
            }
        }
        //---
        //$request->type == 'product'
        if ($request->type == 'product') {
            foreach ($request->box_id as $box_id) {
                $giftBox = new GiftBox();
                $giftBox->box_id = $box_id;
                $giftBox->gift_id = $row->id;
                $giftBox->save();
            }
            foreach ($request->main_category_id as $main_category_id) {
                $giftMainCategory = new GiftMainCategory();
                $giftMainCategory->main_category_id = $main_category_id;
                $giftMainCategory->gift_id = $row->id;
                $giftMainCategory->save();
            }
        }
        //---

        return redirect()->back()->with('message', trans('lang.added_s'));
    }

    public function edit($id)
    {
        if (!$this->permission()) return "Not Authorized";

        $main_categories = MainCategory::all();
        $boxs = Box::all();
        $gift_main_categories = GiftMainCategory::whereGiftId($id)->pluck('main_category_id')->toArray();
        $gift_boxes = GiftBox::whereGiftId($id)->pluck('box_id')->toArray();
        $row = Gift::findOrFail($id);
        return view('Admin.gifts.edit',
            compact('row', 'boxs', 'main_categories', 'gift_main_categories', 'gift_boxes'));
    }

    public function show($id)
    {
        if (!$this->permission()) return "Not Authorized";



        $targetSum = 100; // Set the target sum
        $numberOfRandomNumbers = 10; // Set the number of random numbers to generate
        $minValue = 1; // Minimum value for random numbers
        $maxValue = 10; // Maximum value for random numbers

        $randomNumbers = [];

// Generate n-1 random numbers
        for ($i = 0; $i < $numberOfRandomNumbers - 1; $i++) {
            $randomNumbers[] = mt_rand($minValue, $maxValue);
        }

// Adjust the last element to make the sum equal to the target sum
        $randomNumbers[$numberOfRandomNumbers - 1] = $targetSum - array_sum($randomNumbers);

// Print or use the generated random numbers
//                dd($randomNumbers,array_sum($randomNumbers));

        return view('Admin.gifts.money_details',compact('id'));
    }

    public function update(Request $request, $id)
    {
        if (!$this->permission()) return "Not Authorized";


        $row = Gift::findOrFail($id);

        $request->validate([
            'main_category_id' => 'required_if:type,product|array',
            'box_id' => 'required_if:type,product|array',
            'title_ar' => 'required|string',
            'title_en' => 'required|string',
//            'money_amount' => 'required|numeric',
            'type' => 'required|in:product,money',
            'image' => 'nullable|image',
        ]);

        $row->title_ar = $request->title_ar;
        $row->title_en = $request->title_en;
//        $row->money_amount = $request->money_amount;
//        $row->money_out = 0;
//        $row->money_remain = $request->money_amount;
//        $row->type = $request->type;
        $row->image = $request->image;
        $row->save();

        GiftMainCategory::whereGiftId($id)->delete();
        GiftBox::whereGiftId($id)->delete();
        if ($row->type == 'product') {
            foreach ($request->box_id as $box_id) {
                $giftBox = new GiftBox();
                $giftBox->box_id = $box_id;
                $giftBox->gift_id = $row->id;
                $giftBox->save();
            }
            foreach ($request->main_category_id as $main_category_id) {
                $giftMainCategory = new GiftMainCategory();
                $giftMainCategory->main_category_id = $main_category_id;
                $giftMainCategory->gift_id = $row->id;
                $giftMainCategory->save();
            }
        }

        return redirect()->back()->with('message', trans('lang.updated_s'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function delete(Request $request)
    {
        try {
            Gift::whereIn('id', $request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed']);
        }
        return response()->json(['message' => 'Success']);
    }

    public function changeActive(Request $request)
    {
        $box = Gift::where('id', $request->id)->first();
        if ($box->active == 0)
            Gift::where('id', $request->id)->update(['active' => 1]);
        else
            Gift::where('id', $request->id)->update(['active' => 0]);
        return 1;
    }
}
