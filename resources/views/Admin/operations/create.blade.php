@extends('layout.layout')

@php
    $route = 'operations';
@endphp

@section('style')
    <style>
        @media (min-width: 992px) {
            .aside-me .content {
                padding-right: 30px;
            }
        }
    </style>
@endsection
@section('header')
    <!--begin::Heading-->
    <h1 class="text-dark fw-bolder my-0 fs-2"> {{trans('lang.create')}}</h1>
    <!--end::Heading-->
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb fw-bold fs-base my-1">
        <li class="breadcrumb-item">
            <a href="{{url('/')}}" class="text-muted">
                {{trans('lang.Dashboard')}} </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{route($route.'.index')}}" class="text-muted">
                {{trans('lang.'.$route)}} </a>
        </li>
        <li class="breadcrumb-item">
            {{trans('lang.create')}}
        </li>
    </ul>
    <!--end::Breadcrumb-->
@endsection


@section('content')
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <!--begin::Post-->

        <div class="content flex-row-fluid" id="kt_content">

            <!--begin::Basic info-->
            <div class="card mb-5 mb-xl-10">
                <!--begin::Card header-->
                <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                     data-bs-target="#kt_account_profile_details" aria-expanded="true"
                     aria-controls="kt_account_profile_details">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bolder m-0">{{__('lang.create')}}</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->
                <!--begin::Content-->
                <div id="kt_account_settings_profile_details" class="collapse show">
                    <!--begin::Form-->
                    <form id="kt_account_profile_details_form" action="{{url($route.'/store/')}}"
                          class="form"
                          method="post" enctype="multipart/form-data">
                    @csrf
                    <!--begin::Card body-->
                        <div class="card-body border-top p-9">
                            <!--begin::Input group-->

                            <div class="fv-row mb-7 ">
                                <!--begin::Label-->
                                <label class="required fw-bold fs-6 mb-2">{{__('lang.empty_weight')}}</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <div class="row">
                                    <div class="col-6">
                                        <input type="text" name="empty_weight"
                                               class="form-control form-control-solid mb-3 mb-lg-0  "
                                               placeholder="" id="output" value="0" required/>
                                        <!--end::Input-->
                                    </div>
                                    <div class="col-6">
                                        <a  id="connectButton" class="btn btn-light-success me-3 font-weight-bolder col-6">
                                            <i class="bi bi-minecart-loaded fs-2x"></i>
                                        </a>
                                    </div>
                                </div>

                            </div>

                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-bold fs-6 mb-2">{{__('lang.payment_type')}}</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select class="form-control input-text  select2   mb-3 mb-lg-0"
                                        name="payment_type"
                                >
                                    <option

                                        value="cash">{{__('lang.cash')}}</option>
                                    <option
                                        value="online">{{__('lang.online')}}</option>
                                </select>
                                <!--end::Input-->
                            </div>

                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-bold fs-6 mb-2">{{__('lang.car_num')}}</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="car_num"
                                       class="form-control form-control-solid mb-3 mb-lg-0"
                                       placeholder="" required/>
                                <!--end::Input-->
                            </div>

                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-bold fs-6 mb-2">{{__('lang.driver_name')}}</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="driver_name"
                                       class="form-control form-control-solid mb-3 mb-lg-0"
                                       placeholder="" required/>
                                <!--end::Input-->
                            </div>

                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-bold fs-6 mb-2">{{__('lang.transporter_name')}}</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="transporter_name"
                                       class="form-control form-control-solid mb-3 mb-lg-0"
                                       placeholder="" required/>
                                <!--end::Input-->
                            </div>

                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-bold fs-6 mb-2">{{__('lang.client_name')}}</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="client_name"
                                       class="form-control form-control-solid mb-3 mb-lg-0"
                                       placeholder="" required/>
                                <!--end::Input-->
                            </div>
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-bold fs-6 mb-2">{{__('lang.customer_tax')}}</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="customer_tax"
                                       class="form-control form-control-solid mb-3 mb-lg-0"
                                       placeholder="" required/>
                                <!--end::Input-->
                            </div>

                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-bold fs-6 mb-2">{{__('lang.item')}}</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select class="form-control input-text  select2   mb-3 mb-lg-0"
                                        name="item"
                                >
                                    <option

                                        value="زلط سن">زلط سن
                                    </option>
                                    <option
                                        value="رمال حمراء">رمال حمراء
                                    </option>
                                </select>
                                <!--end::Input-->
                            </div>

                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-bold fs-6 mb-2">{{__('lang.unit')}}</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select class="form-control input-text  select2   mb-3 mb-lg-0"
                                        name="unit"
                                >
                                    <option
                                        value="ton"> {{trans('lang.ton')}}
                                    </option>
                                    <option
                                        value="kg"> {{trans('lang.kg')}}
                                    </option>
                                </select>
                                <!--end::Input-->
                            </div>

                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-bold fs-6 mb-2">{{__('lang.crusher_num')}}</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="number" name="crusher_num"
                                       class="form-control form-control-solid mb-3 mb-lg-0"
                                       placeholder="" required/>
                                <!--end::Input-->
                            </div>

                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-bold fs-6 mb-2">{{__('lang.temperature')}}</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="temperature"
                                       class="form-control form-control-solid mb-3 mb-lg-0"
                                       placeholder="" required/>
                                <!--end::Input-->
                            </div>
                        </div>

                        <!--end::Scroll-->
                        <!--begin::Actions-->

                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <button type="submit" class="btn btn-primary"
                                    id="kt_account_profile_details_submit">{{__('lang.save')}}
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Basic info-->

        </div>
        <!--end::Post-->
    </div>
@endsection

@section('script')


    <script>
        $( "#connectButton" ).on( "click", function() {
        const connectButton = document.getElementById('connectButton');
        const outputElement = document.getElementById('output');

        async function connectSerial() {
            try {
                const port = await navigator.serial.requestPort();
                await port.open({ baudRate: 9600 });

                const reader = port.readable.getReader();

                while (true) {
                    const { value, done } = await reader.read();
                    if (done) {
                        reader.releaseLock();
                        break;
                    }

                    outputElement.textContent += new TextDecoder().decode(value);
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }

       connectButton.addEventListener('click', connectSerial);

        } );
    </script>


@endsection

