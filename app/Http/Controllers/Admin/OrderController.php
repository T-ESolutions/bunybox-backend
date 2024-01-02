<?php

namespace App\Http\Controllers\Admin;

use App\Models\Meal;
use App\Models\MealType;
use App\Models\Notification;
use App\Models\NotificationSetting;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderMeal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    public function permission()
    {
        return auth()->guard('admin')->user()->can('orders');
    }

    public function index()
    {
        if (!$this->permission()) return "Not Authorized";

        return view('Admin.orders.index');
    }

    public function create()
    {

        if (!$this->permission()) return "Not Authorized";

        return view('Admin.orders.create', compact('status'));

    }

    public function store(Request $request)
    {
        if (!$this->permission()) return "Not Authorized";

        $validator = Validator::make($request->all(), [
            'title_ar' => 'required',
            'title_en' => 'required',
            'type' => 'required',
            'image' => 'required|image|mimes:png,jpg,jpeg',
        ]);
        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $row = new Order();
        $row->image = $request->image;
        $row->title_ar = $request->title_ar;
        $row->title_en = $request->title_en;
        $row->type = $request->type;
        $row->save();
        session()->flash('success', 'تم الإضافة بنجاح');
        return redirect()->route('admin.orders', [$request->status]);
    }

    public function edit($id)
    {
        if (!$this->permission()) return "Not Authorized";

        $order = Order::findOrFail($id);

        if (!$order) {
            session()->flash('error', 'الحقل غير موجود');
            return redirect()->back();
        }
        return view('Admin.orders.invoice', compact('order'));
//        return view('Admin.orders.details',
//            compact('order'));
    }


    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'row_id' => 'required|exists:meal_types,id',
        ]);
        if (!is_array($validator) && $validator->fails()) {
            return response()->json(['message' => 'Failed']);
        }

        $row = Order::where('id', $request->row_id)->first();
//        if (!empty($city->getOriginal('image'))){
//            unlinkFile($city->getOriginal('image'), 'cities');
//        }
        $row->delete();
        session()->flash('success', 'تم الحذف بنجاح');
        return response()->json(['message' => 'Success']);
    }

    public function deleteMulti(Request $request)
    {
        $ids_array = explode(',', $request->ids);
        foreach ($ids_array as $id) {
            $delete = $this->destroy($id);
            if (!$delete) {
                session()->flash('success', 'حدث خطأ ما');
                return redirect()->back();
            }
        }
        session()->flash('success', 'تم الحذف بنجاح');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $row = Order::where('id', $id)->first();
//        if (!empty($city->getOriginal('image'))){
//            unlinkFile($city->getOriginal('image'), 'cities');
//        }
        return $row->delete();
    }

    public function table_buttons()
    {
        return view('Admin.orders.button');
    }

    public function datatable()
    {
        if (!$this->permission()) return "Not Authorized";

        $auth = Auth::guard('admin')->user();
        $model = Order::query()->orderBy('id', 'desc');

        return DataTables::eloquent($model)
            ->addIndexColumn()
            ->addColumn('checkbox', function ($row) {
                $checkbox = '';
                $checkbox .= '<div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input selector checkbox" type="checkbox" value="' . $row->id . '" />
                                </div>';
                return $checkbox;
            })->addColumn('mainCategory', function ($row) {
                $main_category_name = $row->mainCategory ? $row->mainCategory->title : "";
                return '<b  class="badge badge-secondary">
                ' . $main_category_name . '
                        </b>';
            })
            ->addColumn('user_name', function ($row) {
                $user_name = $row->user ? $row->user->name : '';
                $main_category_name = $row->mainCategory ? $row->mainCategory->title : "";
                if ($row->user) {
                    return '<a href="' . route('users.edit', [$row->user_id]) . '" target="_blank" class="" title="العميل">
                            ' . $user_name . '
                        </a>
                       ';
                } else {
                    return '<a class="badge badge-danger">' . trans('lang.user_deleted') . '</a>';
                }

            })
            ->addColumn('box', function ($row) {
                $box = $row->box->title;

                if ($row->is_offer == 1)
                    $offer = '<br><b class="badge badge-warning">' . trans("lang.Offer") . '</b>';
                else
                    $offer = '';

                return '<a href="' . route('boxes.edit', [$row->box_id]) . '" target="_blank" class="" title="الصندوق">
                            ' . $box . '
                        </a>' . $offer;
            })
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format("Y-m-d (H:i) A");
            })
            ->editColumn('delivered_at', function ($row) {
                return Carbon::parse($row->created_at)->format("Y-m-d (H:i) A");
            })
            ->editColumn('status', function ($row) {
                if ($row->status == 'ordered')
                    return '<b class="badge badge-info">' . trans('lang.' . $row->status) . '</b>';
                elseif ($row->status == 'shipped')
                    return '<b class="badge badge-warning">' . trans('lang.' . $row->status) . '</b>';
                elseif ($row->status == 'delivered')
                    return '<b class="badge badge-success">' . trans('lang.' . $row->status) . '</b>';
                else
                    return '-';
            })
            ->editColumn('payment_status', function ($row) {
                if ($row->payment_status == 'unpaid')
                    return '<b class="badge badge-dark">' . trans('lang.' . $row->payment_status) . '</b>';
                elseif ($row->payment_status == 'paid')
                    return '<b class="badge badge-primary">' . trans('lang.' . $row->payment_status) . '</b>';
                else
                    return '-';
            })
            ->addColumn('actions', function ($row) {
                $buttons = '';
//
                $buttons .= '<a href="' . route('orders.edit', [$row->id]) . '" class="btn btn-success btn-circle btn-sm m-1" title="' . __('lang.show_details') . '" target="_blank">
                            <i class="fa fa-eye"></i>
                        </a>';
                $buttons .= '<a href="#" data-id="' . $row->id . '" data-status="' . $row->status . '" data-status="' . $row->status . '" title="' . __('lang.change_status') . '" class="btn btn-sm btn-primary changeStatus" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app" id="kt_toolbar_primary_button"><i class="fa fa-edit"></i></a>';
//
                return $buttons;
            })
            ->rawColumns(['actions', 'checkbox', 'box',
                'user_name', 'status', 'payment_status', 'mainCategory',
                'created_at', 'order_id'])
            ->make();

    }

    public function orderDetails(Request $request, $order_id)
    {
        if (!$this->permission()) return "Not Authorized";

        $auth = Auth::guard('admin')->user();
        $model = OrderItem::query()
            ->where('order_id', $order_id);

        return DataTables::eloquent($model)
            ->addIndexColumn()
            ->addColumn('checkbox', function ($row) {
                $checkbox = '';
                $checkbox .= '<div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input selector checkbox" type="checkbox" value="' . $row->id . '" />
                                </div>';
                return $checkbox;
            })
            ->addColumn('product', function ($row) {
                $box = $row->product->title_ar;
                return '<a href="' . route('products.edit', [$row->product_id]) . '" target="_blank" class="" title="الصندوق">
                            ' . $box . '
                        </a>';
            })
            ->addColumn('category', function ($row) {
                $box = $row->category->title_ar;
                return '<a href="' . route('categories.edit', [$row->category_id]) . '" target="_blank" class="" title="الصندوق">
                            ' . $box . '
                        </a>';
            })
            ->editColumn('type', function ($row) {
                if ($row->type == 'basic')
                    return '<b class="badge badge-info">' . $row->type . '</b>';
                elseif ($row->type == 'selected')
                    return '<b class="badge badge-warning">' . $row->type . '</b>';
                elseif ($row->type == 'gift')
                    return '<b class="badge badge-success">' . $row->type . '</b>';
                else
                    return '-';
            })
            ->addColumn('actions', function ($row) use ($auth) {
                $buttons = '';
//                if ($auth->can('sliders.update')) {
                $buttons .= '<a href="#" data-id="' . $row->id . '" data-status="' . $row->status . '" class="btn btn-sm btn-primary changeStatus" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app" title="تغيير الحالة" id="kt_toolbar_primary_button"><i class="fa fa-edit"></i></a>';

//                $buttons .= '<a href="'.route('admin.orders.edit',[$row->id]).'" class="btn btn-success btn-circle btn-sm m-1" title="عرض التفاصيل" target="_blank">
//                            <i class="fa fa-eye"></i>
//                        </a>';
//                }
//                if ($auth->can('sliders.delete')) {
//                    $buttons .= '<a class="btn btn-danger btn-sm delete btn-circle m-1" data-id="'.$row->id.'"  title="حذف">
//                            <i class="fa fa-trash"></i>
//                        </a>';
//                }
                return $buttons;
            })
            ->rawColumns(['actions', 'checkbox', 'product', 'category', 'type'])
            ->make();
    }

    public function changeOrderStatus(Request $request)
    {
        if (!$this->permission()) return "Not Authorized";

        $validator = Validator::make($request->all(), [
            'row_id' => 'required|exists:orders,id',
        ]);
        if (!is_array($validator) && $validator->fails()) {
            session()->flash('success', 'حدث خطأ ما');
            return redirect()->back();
        }
        $row = Order::whereId($request->row_id)->first();
        $row->status = $request->status;
        if ($request->status == 'delivered') {
            $row->delivered_at = Carbon::now();
        }
        $row->save();

        session()->flash('success', 'تم التعديل بنجاح');
        return redirect()->back();
    }
}
