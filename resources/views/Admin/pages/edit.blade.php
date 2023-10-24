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
                    من نحن
                @elseif($type == 'terms')
                    الشروط والاحكام
                @elseif($type == 'privacy')
                    سياسة الخصوصية
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
                <!--begin::Aside column-->
{{--                <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px">--}}
{{--                    <!--begin::Thumbnail settings-->--}}
{{--                    <div class="card card-flush py-4">--}}
{{--                        <!--begin::Card header-->--}}
{{--                        <div class="card-header">--}}
{{--                            <!--begin::Card title-->--}}
{{--                            <div class="card-title">--}}
{{--                                <h2>الصورة</h2>--}}
{{--                            </div>--}}
{{--                            <!--end::Card title-->--}}
{{--                        </div>--}}
{{--                        <!--end::Card header-->--}}
{{--                        <!--begin::Card body-->--}}
{{--                        <div class="card-body text-center pt-0">--}}
{{--                            <!--begin::Image input-->--}}
{{--                            <div class="image-input image-input-empty image-input-outline mb-3"--}}
{{--                                 data-kt-image-input="true" style="">--}}
{{--                                <!--begin::Preview existing avatar-->--}}
{{--                                <div class="image-input-wrapper w-150px h-150px"--}}
{{--                                     style="background-image: url({{$row->image}})"></div>--}}
{{--                                <!--end::Preview existing avatar-->--}}
{{--                                <!--begin::Label-->--}}
{{--                                <label--}}
{{--                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"--}}
{{--                                    data-kt-image-input-action="change" data-bs-toggle="tooltip"--}}
{{--                                    title="إختر الصورة">--}}
{{--                                    <i class="bi bi-pencil-fill fs-7"></i>--}}
{{--                                    <!--begin::Inputs-->--}}
{{--                                    <input type="file" name="image" accept=".png, .jpg, .jpeg"/>--}}
{{--                                    <input type="hidden"/>--}}
{{--                                    <!--end::Inputs-->--}}
{{--                                </label>--}}
{{--                                <!--end::Label-->--}}
{{--                                <!--begin::Cancel-->--}}
{{--                                <span--}}
{{--                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"--}}
{{--                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip"--}}
{{--                                    title="إلغاء الصورة">--}}
{{--														<i class="bi bi-x fs-2"></i>--}}
{{--													</span>--}}
{{--                                <!--end::Cancel-->--}}
{{--                                <!--begin::Remove-->--}}
{{--                                <span--}}
{{--                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"--}}
{{--                                    data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="حذف الصورة">--}}
{{--														<i class="bi bi-x fs-2"></i>--}}
{{--													</span>--}}
{{--                                <!--end::Remove-->--}}
{{--                            </div>--}}
{{--                            <!--end::Image input-->--}}
{{--                            <!--begin::Description-->--}}
{{--                            <div class="text-danger fs-7"> *.png - *.jpg - *.jpeg</div>--}}
{{--                            <!--end::Description-->--}}
{{--                        </div>--}}
{{--                        <!--end::Card body-->--}}
{{--                    </div>--}}
{{--                    <!--end::Thumbnail settings-->--}}

{{--                </div>--}}
                <!--end::Aside column-->
                <!--begin::Main column-->
                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <!--begin:::Tabs-->
                {{--                        <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-n2">--}}
                {{--                            <!--begin:::Tab item-->--}}
                {{--                            <li class="nav-item">--}}
                {{--                                <a class="nav-link text-active-warning pb-4 active" data-bs-toggle="tab"--}}
                {{--                                   href="#kt_ecommerce_add_product_general">--}}
                {{--                                    بيانات--}}
                {{--                                    @if($type == 'about')--}}
                {{--                                        صفحة عن التطبيق--}}
                {{--                                    @elseif($type == 'terms')--}}
                {{--                                        صفحة الشروط والاحكام--}}
                {{--                                    @elseif($type == 'frozen')--}}
                {{--                                        صفحة سياسة التجميد--}}
                {{--                                    @endif--}}
                {{--                                </a>--}}
                {{--                            </li>--}}
                {{--                            <!--end:::Tab item-->--}}
                {{--                            <!--begin:::Tab item-->--}}
                {{--                        --}}{{--                            <li class="nav-item">--}}
                {{--                        --}}{{--                                <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_ecommerce_add_product_advanced">Advanced</a>--}}
                {{--                        --}}{{--                            </li>--}}
                {{--                        <!--end:::Tab item-->--}}
                {{--                        </ul>--}}
                <!--end:::Tabs-->
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
                                                بيانات
                                                @if($type == 'about_us')
                                                    صفحة عن التطبيق
                                                @elseif($type == 'terms')
                                                    صفحة الشروط والاحكام
                                                @elseif($type == 'privacy')
                                                    صفحة سياسة الخصوصية
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
                                            <label class="required form-label">وصف الصفحات (بالعربي)</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <textarea id="editor1" name="title_ar"
                                                      value=""
                                                      placeholder="وصف الصفحة (بالعربي)">{!!  $row->title_ar !!}</textarea>
                                            <!--end::Input-->
                                            <!--begin::Description-->
                                        {{--                                                <div class="text-muted fs-7">A product name is required and recommended to be unique.</div>--}}
                                        <!--end::Description-->
                                        </div>

                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">وصف الصفحات (بالإنجليزي)</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <textarea id="editor2" name="title_en"
                                                      value=""
                                                      placeholder="وصف الصفحة (بالإنجليزي)">{!!  $row->title_en !!}</textarea>
                                            <!--end::Input-->
                                            <!--begin::Description-->
                                        {{--                                                <div class="text-muted fs-7">A product name is required and recommended to be unique.</div>--}}
                                        <!--end::Description-->
                                        </div>
                                        <!--end::Input group-->

                                    </div>
                                    <!--end::Card header-->
                                </div>
                                <!--end::General options-->

                            </div>
                        </div>
                        <!--end::Tab pane-->
                    </div>
                    <!--end::Tab content-->
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

