@extends('layout.layout')
@php
    $route = 'orders';
@endphp
@section('title',__("lang.$route"))
@section('header')
    <!--begin::Heading-->
    <h1 class="text-dark fw-bolder my-0 fs-2">
        {{trans('lang.'.$route)}}

    </h1>
    <!--end::Heading-->
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb fw-bold fs-base my-1">
        <li class="breadcrumb-item">
            <a href="{{url('/')}}" class="text-muted">
                {{trans('lang.Dashboard')}} </a>
        </li>
        <li class="breadcrumb-item">
            {{trans('lang.'.$route)}}
        </li>
        <li class="breadcrumb-item">
            {{trans('lang.'.'order_details')}}
            :&nbsp;
            <b class="badge badge-primary">
                {{$order->id}}
            </b>
        </li>
    </ul>


    <!--end::Breadcrumb-->
@endsection

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Container-->
        <div class="container-xxl" id="kt_content_container">
            <!-- begin::Invoice 1-->
            <div class="card">
                <!-- begin::Body-->
                <div class="card-body py-20">
                    <!-- begin::Wrapper-->
                    <div class="mw-lg-950px mx-auto w-100">
                        <!-- begin::Header-->
                        <div class="d-flex justify-content-between flex-column flex-sm-row mb-19">
                            <h4 class="fw-boldest text-gray-800 fs-2qx pe-5 pb-7"> {{trans('lang.invoice')}}  </h4>
                        {{--                            #{{$order->id}}--}}
                        <!--end::Logo-->
                            <div class="text-sm-end">
                                <a href="#">
                                    <img alt="Logo" style="width: 70px;height: 70px" src="{{url('logo/logo.png')}}">
                                </a>
                                <!--end::Logo-->
                                <!--begin::Text-->
                                <div class="text-sm-end fw-bold fs-4 text-muted mt-7">
                                    <div>{{$order->address_data->location}}  {{$order->address_data->address}}</div>
                                    <div>{{$order->address_data->phone}}</div>

                                </div>
                                <!--end::Text-->
                            </div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="border-bottom pb-12">
                            <!--begin::Image-->
                            <!--end::Image-->
                            <!--begin::Wrapper-->
                            <div class="d-flex justify-content-between flex-column flex-md-row">
                                <!--begin::Content-->
                                <div class="flex-grow-1 pt-8 mb-13">
                                    <!--begin::Table-->
                                    <div class="table align-middle table-row-dashed fs-6 gy-5">
                                        <table class="table">
                                            <thead>
                                            <tr class="border-bottom fs-6 fw-bolder text-muted text-uppercase">
                                                <th class="min-w-175px pb-9">{{__('lang.image')}}</th>
                                                <th class="min-w-175px pb-9">{{__('lang.products')}}</th>
                                                <th class="min-w-175px pb-9">{{__('lang.categories')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($order->items as $item)
                                                <tr>
                                                    <td class="d-flex align-items-center pt-11 bold">
                                                        <img alt="product" style="width: 70px;height: 70px" src="{{url($item->product->image)}}">

                                                    </td>
                                                    <td class="pt-11 bold">
                                                        {{$item->product->title}}
                                                    </td>  <td class="pt-11 bold">
                                                        {{$item->category->title}}
                                                    </td>
                                                </tr>
                                            @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                    <hr>
                                    <!--end::Table-->
                                    <div class="align-middle  fs-6 fw-bolder text-muted text-uppercase">
                                        <h3 class="min-w-175px pb-9 text-muted">GIFT</h3>
                                            <div class="row">
                                                <div class="col-md-4">{{__('lang.image')}} </div>
                                                <div class="col-md-4">{{__('lang.title')}} </div>
                                                <div class="col-md-4">{{__('lang.gift_type')}} </div>
                                            </div>
                                        <hr>

                                        <div class="row">
                                                <div class="col-md-4">  <img alt="Logo" style="width: 70px;height: 70px" src="{{$order->gift_data_json->image}}"> </div>
                                                <div class="col-md-4">{{$order->gift_data_json->title}} </div>
                                                <div class="col-md-4">{{trans('lang.'.$order->gift_data_json->type)}} </div>
                                            </div>

                                    </div>
                                    <!--begin::Section-->

                                    <!--end::Section-->
                                </div>
                                <!--end::Content-->
                                <!--begin::Separator-->
                                <div class="border-end d-none d-md-block mh-450px mx-9"></div>
                                <!--end::Separator-->
                                <!--begin::Content-->
                                <div class="text-end pt-10">
                                    <!--begin::Total Amount-->
                                    <div class="fs-3 fw-bolder text-muted mb-3">{{trans('lang.total_price')}}</div>
                                    <div class="fs-xl-2x fs-2 fw-boldest">{{$order->total}} {{trans('lang.currency')}}</div>
                                    <div class="text-muted fw-bold">{{trans('lang.price')}}</div>
                                    <div class="fs-xl-2x fs-2 ">{{$order->price}} {{trans('lang.currency')}}</div>
                                    <div class="text-muted fw-bold">{{trans('lang.shipping')}}</div>
                                    <div class="fs-xl-2x fs-2 ">{{$order->shipping_cost}} {{trans('lang.currency')}}</div>
                                    <!--end::Total Amount-->
                                    <div class="border-bottom w-100 my-7 my-lg-16"></div>
                                    <!--begin::Invoice To-->
                                    <div class="text-gray-600 fs-6 fw-bold mb-3">{{trans('lang.INVOICE TO')}}</div>
                                    <div class="fs-6 text-gray-800 fw-bold mb-8"> {{$order->address_data->address}}
                                        <br>{{$order->address_data->location}}
                                    </div>
                                    <!--end::Invoice To-->
                                    <!--begin::Invoice No-->
                                    <div class="text-gray-600 fs-6 fw-bold mb-3">{{trans('lang.INVOICE NO')}}</div>
                                    <div class="fs-6 text-gray-800 fw-bold mb-8">#{{$order->id}}</div>
                                    <!--end::Invoice No-->
                                    <!--begin::Invoice Date-->
                                    <div class="text-gray-600 fs-6 fw-bold mb-3">{{trans('lang.order_date')}}</div>
                                    <div class="fs-6 text-gray-800 fw-bold">{{\Carbon\Carbon::parse($order->created_at)->translatedFormat("d M Y")}}</div>
                                    <!--end::Invoice Date-->
                                </div>
                                <!--end::Content-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Body-->
                        <!-- begin::Footer-->
                        <div class="d-flex flex-stack flex-wrap mt-lg-20 pt-13">
                            <!-- begin::Actions-->
                            <div class="my-1 me-5">
                                <!-- begin::Pint-->
{{--                                <button type="button" class="btn btn-success my-1 me-12" onclick="window.print();">Print--}}
{{--                                    Invoice--}}
{{--                                </button>--}}
                                <!-- end::Pint-->
                                <!-- begin::Download-->

                                <!-- end::Download-->
                            </div>
                            <!-- end::Actions-->
                            <!-- begin::Action-->

                            <!-- end::Action-->
                        </div>
                        <!-- end::Footer-->
                    </div>
                    <!-- end::Wrapper-->
                </div>
                <!-- end::Body-->
            </div>
            <!-- end::Invoice 1-->
        </div>
        <!--end::Container-->
    </div>

@endsection

@section('script')


@endsection

