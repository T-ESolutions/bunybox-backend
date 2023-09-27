<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\OrderRequest;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function placeOrder(OrderRequest $request)
    {

        dd($request);


    }
}
