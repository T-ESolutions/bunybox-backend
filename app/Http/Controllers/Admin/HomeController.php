<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Box;
use App\Models\Category;
use App\Models\Gift;
use App\Models\MainCategory;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class HomeController extends Controller
{



    public function index()
    {
        $data['admins'] = Admin::count();
        $data['users'] = User::count();
        $data['boxes'] = Box::where('is_offer',0)->count();
        $data['gifts'] = Gift::count();

        $data['main_categories'] = MainCategory::count();
        $data['categories'] = Category::count();
        $data['products'] = Product::count();
        $data['offers'] = Box::where('is_offer',1)->count();

        $data['orders'] = Order::count();
        $data['ordered_orders'] = Order::where('status','ordered')->count();
        $data['shipped_orders'] = Order::where('status','shipped')->count();
        $data['delivered_orders'] = Order::where('status','delivered')->count();

        return view('Admin.index',compact('data'));
    }


    public function translate($word){
        return trans('lang.'.$word);
    }
}
