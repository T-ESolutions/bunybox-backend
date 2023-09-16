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
    <h1 class="text-dark fw-bolder my-0 fs-2"> {{trans('lang.edit')}}</h1>
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
            {{trans('lang.edit')}}
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
                        <h3 class="fw-bolder m-0">{{__('lang.Users_Edit')}}</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->
                <!--begin::Content-->
                <div id="kt_account_settings_profile_details" class="collapse show">
                    <!--begin::Form-->
                    <form id="kt_account_profile_details_form" action="{{url($route.'/update/'.$data->id)}}"
                          class="form"
                          method="post" enctype="multipart/form-data">
                    @csrf
                    <!--begin::Card body-->
                        <div class="card-body border-top p-9">

                            <div class="fv-row mb-7 text-center" style="text-align: center">


                                <div class="mb-3">{!! DNS1D::getBarcodeHTML('4445645656', 'CODABAR') !!}</div>


                            </div>
                            <!--begin::Input group-->
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
                                                   placeholder="" value="{{$data->empty_weight}}" readonly/>
                                            <!--end::Input-->
                                        </div>

                                    </div>

                                </div>

                                <div class="fv-row mb-7 ">
                                    <!--begin::Label-->
                                    <label class="required fw-bold fs-6 mb-2">{{__('lang.full_weight')}}</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="text" name="full_weight"
                                                   class="form-control form-control-solid mb-3 mb-lg-0  "
                                                   placeholder="" id="output" value="{{$data->full_weight}}" required/>
                                            <!--end::Input-->
                                        </div>
                                        <div class="col-6">
                                            <a id="connectButton"
                                               class="btn btn-light-success me-3 font-weight-bolder col-6">
                                                <i class="bi bi-minecart-loaded fs-2x"></i>
                                            </a>
                                        </div>
                                    </div>

                                </div>


                                    <div class="fv-row mb-7 ">
                                        <!--begin::Label-->
                                        <label class="required fw-bold fs-6 mb-2">{{__('lang.net_weight')}}</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div class="row">
                                            <div class="col-6">
                                                <input type="text" name="net_weight"
                                                       class="form-control form-control-solid mb-3 mb-lg-0  "
                                                       placeholder=""  required id="net_weight" value="{{$data->net_weight}}"
                                                       />
                                                <!--end::Input-->
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
                                        <option disabled
                                                @if($data->payment_type == "cash") selected @endif
                                                value="cash">{{__('lang.cash')}}</option>
                                        <option disabled
                                                @if($data->payment_type == "online") selected @endif
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
                                           placeholder="" value="{{$data->car_num}}" readonly/>
                                    <!--end::Input-->
                                </div>

                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="required fw-bold fs-6 mb-2">{{__('lang.driver_name')}}</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="driver_name"
                                           class="form-control form-control-solid mb-3 mb-lg-0"
                                           placeholder="" value="{{$data->driver_name}}" readonly/>
                                    <!--end::Input-->
                                </div>

                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="required fw-bold fs-6 mb-2">{{__('lang.transporter_name')}}</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="transporter_name"
                                           class="form-control form-control-solid mb-3 mb-lg-0"
                                           placeholder="" readonly value="{{$data->transporter_name}}"/>
                                    <!--end::Input-->
                                </div>

                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="required fw-bold fs-6 mb-2">{{__('lang.client_name')}}</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="client_name"
                                           class="form-control form-control-solid mb-3 mb-lg-0"
                                           placeholder="" readonly value="{{$data->client_name}}"/>
                                    <!--end::Input-->
                                </div>
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="required fw-bold fs-6 mb-2">{{__('lang.customer_tax')}}</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="customer_tax"
                                           class="form-control form-control-solid mb-3 mb-lg-0"
                                           placeholder="" readonly value="{{$data->customer_tax}}"/>
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
                                        <option disabled @if($data->item == "زلط سن") selected @endif
                                        value="زلط سن">زلط سن
                                        </option>
                                        <option disabled @if($data->item == "رمال حمراء") selected @endif
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
                                        <option disabled @if($data->unit == "ton") selected @endif
                                        value="ton"> {{trans('lang.ton')}}
                                        </option>
                                        <option disabled @if($data->unit == "kg") selected @endif
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
                                           placeholder="" readonly value="{{$data->crusher_num}}"/>
                                    <!--end::Input-->
                                </div>

                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="required fw-bold fs-6 mb-2">{{__('lang.temperature')}}</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="temperature"
                                           class="form-control form-control-solid mb-3 mb-lg-0"
                                           placeholder="" readonly value="{{$data->temperature}}"/>
                                    <!--end::Input-->
                                </div>
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

        $("#state").change(function () {
            var wahda = $(this).val();

            if (wahda != '') {
                $.get("{{ URL::to('/get-branch')}}" + '/' + wahda, function ($data) {
                    var outs = "";
                    $.each($data, function (title, id) {
                        console.log(title)
                        outs += '<option value="' + id + '">' + title + '</option>'
                    });
                    $('#branche').html(outs);
                });
            }
        });
    </script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>

        tinymce.init({
            selector: 'textarea',  // change this value according to your HTML
            plugins: 'a_tinymce_plugin',
            a_plugin_option: true,
            a_configuration_option: 400
        });
    </script>



    <script>
        $("#connectButton").on("click", function () {
            const connectButton = document.getElementById('connectButton');
            const outputElement = document.getElementById('output');


            async function connectSerial() {
                try {
                    const port = await navigator.serial.requestPort();
                    await port.open({baudRate: 9600});

                    const reader = port.readable.getReader();

                    while (true) {
                        const {value, done} = await reader.read();
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
            var empty_weight = document.getElementById('empty_weight');
            var full_weight = document.getElementById('output');
            var net_weight = document.getElementById('net_weight');

            net_weight.value = full_weight - empty_weight;

        });
    </script>



@endsection

