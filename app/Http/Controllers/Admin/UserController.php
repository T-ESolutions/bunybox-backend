<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\UserRequest;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        return view('Admin.users.index');
    }


    public function create()
    {
        return view('Admin.users.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required',
            'type' => 'required|in:fixed,percent',
            'amount' => 'required|numeric|min:1',
            'min_order_total' => 'required|numeric|min:1',
            'expired_at' => 'required',
            'user_id' => 'sometimes',
        ]);
        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $row = User::create([
            'code' => $request->code,
            'type' => $request->type,
            'amount' => $request->amount,
            'min_order_total' => $request->min_order_total,
            'expired_at' => $request->expired_at,
        ]);
        if(sizeof($request->user_id) > 0){
            foreach ($request->user_id as $user_id){
                User::create([
                    'user_id' => $user_id ,
                    'coupon_id' => $row->id ,
                    'used' => 0,
                ]);
            }
        }
            session()->flash('success', 'تم الإضافة بنجاح');
        return redirect()->route('admin.users');
    }

    public function edit($id)
    {
        $data = User::where('id',$id)->first();
        if (!$data){
            session()->flash('error', 'الحقل غير موجود');
            return redirect()->back();
        }
        return view('Admin.users.edit',compact('data'));
    }

    public function update(UserRequest $request)
    {
        $data = $request->validated();

        $row = User::whereId($request->id)->first();
        $row->update($data);
        $data = $row;
        session()->flash('success', 'تم التعديل بنجاح');
        return view('Admin.users.edit',compact('data'));
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'row_id' => 'required|exists:coupons,id',
        ]);
        if (!is_array($validator) && $validator->fails()) {
            return response()->json(['message' => 'Failed']);
        }

        $row = User::where('id',$request->row_id)->first();
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
            $delete =$this->destroy($id);
            if (!$delete){
                session()->flash('success', 'حدث خطأ ما');
                return redirect()->back();
            }
        }
        session()->flash('success', 'تم الحذف بنجاح');
        return redirect()->back();
    }
    public function destroy($id)
    {
        $row = User::where('id',$id)->first();
//        if (!empty($city->getOriginal('image'))){
//            unlinkFile($city->getOriginal('image'), 'cities');
//        }
        return $row->delete();
    }

    public function datatable()
    {
        $auth = Auth::guard('admin')->user();
        $model = User::query();

        return DataTables::eloquent($model)
            ->addIndexColumn()
            ->addColumn('checkbox', function ($row) {
                $checkbox = '';
                $checkbox .= '<div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input selector checkbox" type="checkbox" value="' . $row->id . '" />
                                </div>';
                return $checkbox;
            })
            ->editColumn('image',function ($row){
                return '<a class="symbol symbol-50px"><span class="symbol-label" style="background-image:url('.$row->image.');"></span></a>';
            })
            ->editColumn('is_active',function ($row){
                if ($row->is_active == 1){
                    return "<b class='badge badge-success'>مفعل</b>";
                }else{
                    return "<b class='badge badge-danger'>غير مفعل</b>";
                }
            })
            ->editColumn('created_at',function ($row){
                return Carbon::parse($row->created_at)->translatedFormat("Y-m-d (h:i) a");
            })
//            ->addColumn('select',function ($row){
//                return '<div class="form-check form-check-sm form-check-custom form-check-solid me-3">
//                                        <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_ecommerce_products_table .form-check-input" value="'.$row->id.'" />
//                                    </div>';
//            })
            ->addColumn('actions', function ($row) use ($auth){
                $buttons = '';
//                if ($auth->can('sliders.update')) {
                    $buttons .= '<a href="'.route('users.edit',[$row->id]).'" class="btn btn-primary btn-circle btn-sm m-1" title="تعديل">
                            <i class="fa fa-edit"></i>
                        </a>';
//                }
//                if ($auth->can('sliders.delete')) {
                    $buttons .= '<a href="'.route('users.user-orders',[$row->id]).'" class="btn btn-warning btn-sm btn-circle m-1" title="الطلبات">
                            <i class="fa fa-cart-plus"></i>
                        </a>';
//                }
//                $buttons .= '<a href="'.route('admin.users.cancelRequests',[$row->id]).'" class="btn btn-danger btn-sm btn-circle m-1" title="طلبات الإلغاء">
//                            <i class="fa fa-recycle"></i>
//                        </a>';
                return $buttons;
            })
            ->rawColumns(['checkbox','image','actions','is_active','created_at'])
            ->make();

    }


    public function userOrders($user_id)
    {
        return view('Admin.users.orders');
    }

    public function userOrdersDatatabe($user_id)
    {
        $auth = Auth::guard('admin')->user();
        $model = Order::query()->orderBy('id','desc')->where('user_id',$user_id);

        return DataTables::eloquent($model)
            ->addIndexColumn()
            ->addColumn('checkbox', function ($row) {
                $checkbox = '';
                $checkbox .= '<div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input selector checkbox" type="checkbox" value="' . $row->id . '" />
                                </div>';
                return $checkbox;
            })
            ->addColumn('user_name',function ($row){
                $user_name = $row->user->name;
                $main_category_name = $row->mainCategory->title_ar;
                return '<a href="'.route('users.edit',[$row->user_id]).'" target="_blank" class="" title="العميل">
                            '.$user_name.'
                        </a><br>
                        <b  class="badge badge-secondary">
                            '.$main_category_name.'
                        </b>';
            })
            ->addColumn('box',function ($row){
                $box = $row->box->title_ar;

                if ($row->is_offer == 1)
                    $offer = '<br><b class="badge badge-warning">offer</b>';
                else
                    $offer = '';

                return '<a href="'.route('boxes.edit',[$row->box_id]).'" target="_blank" class="" title="الصندوق">
                            '.$box.'
                        </a>'.$offer;
            })
            ->editColumn('created_at',function ($row){
                return Carbon::parse($row->created_at)->format("Y-m-d (H:i) A");
            })
            ->editColumn('delivered_at',function ($row){
                return Carbon::parse($row->created_at)->format("Y-m-d (H:i) A");
            })
            ->editColumn('status',function ($row){
                if ($row->status == 'ordered')
                    return '<b class="badge badge-info">' . $row->status . '</b>';
                elseif ($row->status == 'shipped')
                    return '<b class="badge badge-warning">' . $row->status . '</b>';
                elseif ($row->status == 'delivered')
                    return '<b class="badge badge-success">' . $row->status . '</b>';
                else
                    return '-';
            })
            ->editColumn('payment_status',function ($row){
                if ($row->payment_status == 'unpaid')
                    return '<b class="badge badge-dark">' . $row->payment_status . '</b>';
                elseif ($row->payment_status == 'paid')
                    return '<b class="badge badge-primary">' . $row->payment_status . '</b>';
                else
                    return '-';
            })
//            ->addColumn('select',function ($row){
//                return '<div class="form-check form-check-sm form-check-custom form-check-solid me-3">
//                                        <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_ecommerce_products_table .form-check-input" value="'.$row->id.'" />
//                                    </div>';
//            })
            ->addColumn('actions', function ($row) {
                $buttons = '';
//                if ($auth->can('sliders.update')) {
                $buttons .= '<a href="'.route('orders.edit',[$row->id]).'" class="btn btn-success btn-circle btn-sm m-1" title="عرض التفاصيل" target="_blank">
                            <i class="fa fa-eye"></i>
                        </a>';
//                }
//                if ($auth->can('sliders.delete')) {
//                    $buttons .= '<a class="btn btn-danger btn-sm delete btn-circle m-1" data-id="'.$row->id.'"  title="حذف">
//                            <i class="fa fa-trash"></i>
//                        </a>';
//                }
                return $buttons;
            })
            ->rawColumns(['actions','checkbox','box',
                'user_name','status','payment_status',
                'created_at','order_id'])
            ->make();
    }


}
