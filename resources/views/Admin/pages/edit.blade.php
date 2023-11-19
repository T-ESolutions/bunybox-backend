@extends('layout.layout')

@php
    $route = 'pages';
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
            <a href="{{route($route.'.edit',[$type])}}" class="text-muted">
                {{trans('lang.'.$route)}}

                @if($type == 'about_us')
                    ({{__('lang.about_us')}})
                @elseif($type == 'terms')
                    ({{__('lang.terms')}})
                @elseif($type == 'privacy')
                    ({{__('lang.privacy')}})
                @endif
            </a>
        </li>
        <li class="breadcrumb-item">
            {{trans('lang.edit')}}
        </li>
    </ul>
    <!--end::Breadcrumb-->
@endsection


@section('content')
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Form-->
            <form action="{{route('pages.update')}}" method="post" enctype="multipart/form-data"
                  class="form d-flex flex-column flex-lg-row gap-7 gap-lg-10">
                @csrf
                <input type="hidden" name="row_id" value="{{$row->id}}">
                <input type="hidden" name="type" value="{{$type}}">
                <!--begin::Main column-->
                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">

                    <!--begin::Tab content-->
                    <div class="tab-content">
                        <!--begin::Tab pane-->
                        <div class="tab-pane fade show active" id="kt_ecommerce_add_product_general"
                             role="tab-panel">
                            <div class="d-flex flex-column gap-7 gap-lg-10">
                                <!--begin::General options-->
                                <div class="card card-flush py-4">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>
                                                @if($type == 'about_us')
                                                    ({{__('lang.about_us')}})
                                                @elseif($type == 'terms')
                                                    ({{__('lang.terms')}})
                                                @elseif($type == 'privacy')
                                                    ({{__('lang.privacy')}})
                                                @endif
                                            </h2>
                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">

                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">{{__('lang.description')}} ({{__('lang.ar')}})</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <textarea id="editor1" name="title_ar"
                                                      value=""
                                                      placeholder="{{__('lang.description')}} ({{__('lang.ar')}})">{!!  $row->title_ar !!}</textarea>
                                            <!--end::Input-->
                                            <!--begin::Description-->
                                        {{--                                                <div class="text-muted fs-7">A product name is required and recommended to be unique.</div>--}}
                                        <!--end::Description-->
                                        </div>

                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">{{__('lang.description')}} ({{__('lang.en')}})</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <textarea id="editor2" name="title_en"
                                                      value=""
                                                      placeholder="{{__('lang.description')}} ({{__('lang.en')}})">{!!  $row->title_en !!}</textarea>
                                            <!--end::Input-->
                                            <!--begin::Description-->
                                        {{--                                                <div class="text-muted fs-7">A product name is required and recommended to be unique.</div>--}}
                                        <!--end::Description-->
                                        </div>
                                        <!--end::Input group-->
                                        <div class="d-flex justify-content-end">
                                            <!--begin::Button-->
                                            <a href="{{route('home')}}" id="kt_ecommerce_add_product_cancel"
                                               class="btn btn-light me-5">عودة</a>
                                            <!--end::Button-->
                                            <!--begin::Button-->
                                            <button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-secondary">
                                                <span class="indicator-label">حفظ</span>
                                                <span class="indicator-progress">إنتظر قليلا . . .
												<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                            </button>
                                            <!--end::Button-->
                                        </div>
                                    </div>
                                    <!--end::Card header-->
                                </div>
                                <!--end::General options-->

                            </div>

                        </div>
                        <!--end::Tab pane-->

                    </div>
                    <!--end::Tab content-->

                </div>
                <!--end::Main column-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
@endsection

@section('script')
    <script src="{{ URL::asset('assets/plugins/custom/tinymce/tinymce.bundle.js')}}"></script>
    <script>
        var options = {selector: "#editor1"};

        if (KTApp.isDarkMode()) {
            options["skin"] = "oxide-dark";
            options["content_css"] = "dark";
        }

        tinymce.init(options);

    </script>
    <script>
        var options = {selector: "#editor2"};

        if (KTApp.isDarkMode()) {
            options["skin"] = "oxide-dark";
            options["content_css"] = "dark";
        }

        tinymce.init(options);

    </script>
@endsection

