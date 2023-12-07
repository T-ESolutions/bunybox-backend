@extends('layout.layout')

@php
    $route = 'products';
@endphp
@section('title',__("lang.$route"))
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
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">

        <!--begin::Form-->
        <form action="{{route("$route.update",$row->id)}}" method="post" enctype="multipart/form-data"
              class="form d-flex flex-column flex-lg-row gap-7 gap-lg-10">
        @csrf
        <!--begin::Aside column-->
            <!--begin::Main column-->
            <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                <!--begin:::Tabs-->
                <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-n2">
                    <!--begin:::Tab item-->
                {{--                            <li class="nav-item">--}}
                {{--                                <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_ecommerce_add_product_advanced">Advanced</a>--}}
                {{--                            </li>--}}
                <!--end:::Tab item-->
                </ul>
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
                                        <h2>{{__("lang.$route")}}</h2>
                                    </div>
                                </div>
                                <br>
                                <!--begin::Card body-->
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-md-12">

                                            <!--begin::Thumbnail settings-->
                                            <!--begin::Card body-->
                                            <div class="card-body text-center pt-0">
                                                <!--begin::Image input-->
                                                <div class="image-input image-input-empty image-input-outline mb-3"
                                                     data-kt-image-input="true" style="">
                                                    <!--begin::Preview existing avatar-->
                                                    <div class="image-input-wrapper w-150px h-150px"
                                                         style="background-image: url({{$row->image}})"></div>
                                                    <!--end::Preview existing avatar-->
                                                    <!--begin::Label-->
                                                    <label
                                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                        data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                                        title="إختر الصورة">
                                                        <i class="bi bi-pencil-fill fs-7"></i>
                                                        <!--begin::Inputs-->
                                                        <input type="file" name="image" accept=".png, .jpg, .jpeg"/>
                                                        <input type="hidden"/>
                                                        <!--end::Inputs-->
                                                    </label>
                                                    <!--end::Label-->
                                                    <!--begin::Cancel-->
                                                    <span
                                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                        data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                                        title="إلغاء الصورة">
														<i class="bi bi-x fs-2"></i>
													</span>
                                                    <!--end::Cancel-->
                                                    <!--begin::Remove-->
                                                    <span
                                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                        data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                                        title="حذف الصورة">
														<i class="bi bi-x fs-2"></i>
													</span>
                                                    <!--end::Remove-->
                                                </div>
                                                <!--end::Image input-->
                                                <!--begin::Description-->
                                                <div class="text-danger fs-7"> *.png - *.jpg - *.jpeg</div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Card body-->
                                            <!--end::Thumbnail settings-->

                                            <!--begin::Input group-->
                                            <div class="mb-5 fv-row">
                                                <!--begin::Label-->
                                                <label class="required form-label">
                                                    {{__('lang.categories')}}
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <select class="form-control mb-2" name="category_id"
                                                        data-control="select2" data-hide-search="false">
                                                    <option value="">{{trans('lang.select')}}</option>
                                                    @foreach($categories as $category)
                                                        <option
                                                            value="{{$category->id}}" {{$category->id == $row->category_id ? 'selected' : ''}}>
                                                            {{$category->title}}</option>
                                                    @endforeach
                                                </select>
                                                <!--end::Input-->
                                                <!--begin::Description-->
                                            {{--                                                <div class="text-muted fs-7">A product name is required and recommended to be unique.</div>--}}
                                            <!--end::Description-->
                                            </div>
                                            <!--end::Input group-->

                                            <!--begin::Input group-->
                                            <div class="mb-5 fv-row">
                                                <!--begin::Label-->
                                                <label class="required form-label">{{__('lang.name')}}
                                                    ({{__('lang.ar')}}) </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="text" required name="title_ar"
                                                       class="form-control mb-2" value="{{$row->title_ar}}"
                                                       placeholder="{{__('lang.name')}} ({{__('lang.ar')}})"
                                                />
                                                <!--end::Input-->
                                                <!--begin::Description-->
                                            {{--                                                <div class="text-muted fs-7">A product name is required and recommended to be unique.</div>--}}
                                            <!--end::Description-->
                                            </div>
                                            <!--end::Input group-->

                                            <!--begin::Input group-->
                                            <div class="mb-5 fv-row">
                                                <!--begin::Label-->
                                                <label class="required form-label">{{__('lang.name')}}
                                                    ({{__('lang.en')}}) </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="text" required name="title_en"
                                                       class="form-control mb-2" value="{{$row->title_en}}"
                                                       placeholder="{{__('lang.name')}} ({{__('lang.en')}})"
                                                />
                                                <!--end::Input-->
                                                <!--begin::Description-->
                                            {{--                                                <div class="text-muted fs-7">A product name is required and recommended to be unique.</div>--}}
                                            <!--end::Description-->
                                            </div>
                                            <!--end::Input group-->

                                            <!--begin::Input group-->
                                            <div class="mb-5 fv-row">
                                                <!--begin::Label-->
                                                <label class="required form-label">{{__('lang.quantity')}}</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="number" min="0" step="1" required name="quantity"
                                                       class="form-control mb-2" value="{{$row->quantity}}"
                                                       placeholder="{{__('lang.quantity')}}"
                                                />
                                                <!--end::Input-->
                                                <!--begin::Description-->
                                            {{--                                                <div class="text-muted fs-7">A product name is required and recommended to be unique.</div>--}}
                                            <!--end::Description-->
                                            </div>
                                            <!--end::Input group-->

                                            <!--begin::Input group-->
                                            <div class="mb-5 fv-row">
                                                <!--begin::Label-->
                                                <label class="required form-label">{{__('lang.buy_price')}}</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="number" min="0" required name="buy_price"
                                                       class="form-control mb-2" value="{{$row->buy_price}}"
                                                       placeholder="{{__('lang.buy_price')}}"
                                                />
                                                <!--end::Input-->
                                                <!--begin::Description-->
                                            {{--                                                <div class="text-muted fs-7">A product name is required and recommended to be unique.</div>--}}
                                            <!--end::Description-->
                                            </div>
                                            <!--end::Input group-->

                                            <!--begin::Input group-->
                                            <div class="mb-5 fv-row">
                                                <!--begin::Label-->
                                                <label class="required form-label">{{__('lang.sel_price')}}</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="number" min="0" required name="sel_price"
                                                       class="form-control mb-2" value="{{$row->sel_price}}"
                                                       placeholder="{{__('lang.sel_price')}}"
                                                />
                                                <!--end::Input-->
                                                <!--begin::Description-->
                                            {{--                                                <div class="text-muted fs-7">A product name is required and recommended to be unique.</div>--}}
                                            <!--end::Description-->
                                            </div>
                                            <!--end::Input group-->

                                            <!--begin::Input group-->
                                            <div class="mb-5 fv-row">
                                                <!--begin::Label-->
                                                <label class=" form-label">{{__('lang.shoes_size')}}</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="number" min="0" step="1" name="shoes_size"
                                                       class="form-control mb-2" value="{{$row->shoes_size}}"
                                                       placeholder="{{__('lang.shoes_size')}}"
                                                />
                                                <!--end::Input-->
                                                <!--begin::Description-->
                                            {{--                                                <div class="text-muted fs-7">A product name is required and recommended to be unique.</div>--}}
                                            <!--end::Description-->
                                            </div>
                                            <!--end::Input group-->

                                            <!--begin::Input group-->
                                            <div class="mb-5 fv-row">
                                                <!--begin::Label-->
                                                <label class="form-label">{{__('lang.size')}}</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->

                                                <!--begin::Input-->
                                                <select required class="form-control mb-2" name="size"
                                                        data-control="select2" data-hide-search="false">
                                                    <option @if($row->size == null) selected
                                                            @endif value="">{{trans('lang.select')}}</option>
                                                    <option @if($row->size == "S") selected @endif value="S">Small
                                                    </option>
                                                    <option @if($row->size == "L") selected @endif value="L">Large
                                                    </option>
                                                    <option @if($row->size == "XL") selected @endif value="XL">X-Large
                                                    </option>
                                                    <option @if($row->size == "FS") selected @endif value="FS">Free
                                                        Size
                                                    </option>

                                                </select>
                                                <!--end::Input-->
                                                <!--end::Input-->
                                                <!--begin::Description-->
                                            {{--                                                <div class="text-muted fs-7">A product name is required and recommended to be unique.</div>--}}
                                            <!--end::Description-->
                                            </div>
                                            <!--end::Input group-->

                                            <!--begin::Input group-->
                                            <div class="mb-5 fv-row">
                                                <!--begin::Label-->
                                                <label class=" form-label">{{__('lang.min_age')}}</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="number" min="0" step="1" name="min_age"
                                                       class="form-control mb-2" value="{{$row->min_age}}"
                                                       placeholder="{{__('lang.min_age')}}"
                                                />
                                                <!--end::Input-->
                                                <!--begin::Description-->
                                            {{--                                                <div class="text-muted fs-7">A product name is required and recommended to be unique.</div>--}}
                                            <!--end::Description-->
                                            </div>
                                            <!--end::Input group-->

                                            <!--begin::Input group-->
                                            <div class="mb-5 fv-row">
                                                <!--begin::Label-->
                                                <label class=" form-label">{{__('lang.max_age')}}</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="number" min="0" step="1" name="max_age"
                                                       class="form-control mb-2" value="{{$row->max_age}}"
                                                       placeholder="{{__('lang.max_age')}}"
                                                />
                                                <!--end::Input-->
                                                <!--begin::Description-->
                                            {{--                                                <div class="text-muted fs-7">A product name is required and recommended to be unique.</div>--}}
                                            <!--end::Description-->
                                            </div>
                                            <!--end::Input group-->

                                            <!--begin::Input group-->
                                            <div class="mb-5 fv-row">
                                                <!--begin::Label-->
                                                <label class=" form-label">{{__('lang.min_weight')}}</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="number" min="0" step="1" name="min_weight"
                                                       class="form-control mb-2" value="{{$row->min_weight}}"
                                                       placeholder="{{__('lang.min_weight')}}"
                                                />
                                                <!--end::Input-->
                                                <!--begin::Description-->
                                            {{--                                                <div class="text-muted fs-7">A product name is required and recommended to be unique.</div>--}}
                                            <!--end::Description-->
                                            </div>
                                            <!--end::Input group-->

                                            <!--begin::Input group-->
                                            <div class="mb-5 fv-row">
                                                <!--begin::Label-->
                                                <label class=" form-label">{{__('lang.max_weight')}}</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="number" min="0" step="1" name="max_weight"
                                                       class="form-control mb-2" value="{{$row->max_weight}}"
                                                       placeholder="{{__('lang.max_weight')}}"
                                                />
                                                <!--end::Input-->
                                                <!--begin::Description-->
                                            {{--                                                <div class="text-muted fs-7">A product name is required and recommended to be unique.</div>--}}
                                            <!--end::Description-->
                                            </div>
                                            <!--end::Input group-->

                                            <!--begin::Input group-->
                                            <div class="mb-5 fv-row">
                                                <!--begin::Label-->
                                                <label class=" form-label">{{__('lang.min_height')}}</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="number" min="0" step="1" name="min_height"
                                                       class="form-control mb-2" value="{{$row->min_height}}"
                                                       placeholder="{{__('lang.min_height')}}"
                                                />
                                                <!--end::Input-->
                                                <!--begin::Description-->
                                            {{--                                                <div class="text-muted fs-7">A product name is required and recommended to be unique.</div>--}}
                                            <!--end::Description-->
                                            </div>
                                            <!--end::Input group-->

                                            <!--begin::Input group-->
                                            <div class="mb-5 fv-row">
                                                <!--begin::Label-->
                                                <label class=" form-label">{{__('lang.max_height')}}</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="number" min="0" step="1" name="max_height"
                                                       class="form-control mb-2" value="{{$row->max_height}}"
                                                       placeholder="{{__('lang.max_height')}}"
                                                />
                                                <!--end::Input-->
                                                <!--begin::Description-->
                                            {{--                                                <div class="text-muted fs-7">A product name is required and recommended to be unique.</div>--}}
                                            <!--end::Description-->
                                            </div>
                                            <!--end::Input group-->

                                            <!--begin::Input group-->
                                            <div class="mb-5 fv-row">
                                                <!--begin::Label-->
                                                <label class="required form-label">{{__('lang.description')}}
                                                    ({{__('lang.ar')}}) </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <textarea required name="desc_ar"
                                                          placeholder="{{__('lang.description')}} ({{__('lang.ar')}})"
                                                          class="form-control mb-2">{{$row->desc_ar}}</textarea>

                                                <!--end::Input-->
                                                <!--begin::Description-->
                                            {{--                                                <div class="text-muted fs-7">A product name is required and recommended to be unique.</div>--}}
                                            <!--end::Description-->
                                            </div>
                                            <!--end::Input group-->

                                            <!--begin::Input group-->
                                            <div class="mb-5 fv-row">
                                                <!--begin::Label-->
                                                <label class="required form-label">{{__('lang.description')}}
                                                    ({{__('lang.en')}}) </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <textarea required name="desc_en"
                                                          placeholder="{{__('lang.description')}} ({{__('lang.en')}})"
                                                          class="form-control mb-2">{{$row->desc_en}}</textarea>

                                                <!--end::Input-->
                                                <!--begin::Description-->
                                            {{--                                                <div class="text-muted fs-7">A product name is required and recommended to be unique.</div>--}}
                                            <!--end::Description-->
                                            </div>
                                            <!--end::Input group-->

                                        </div>

                                    </div>
                                </div>
                                <!--end::Card header-->
                                <div class="card-footer">
                                    <button type="submit" id="kt_ecommerce_add_product_submit"
                                            class="btn btn-secondary">

                                        <span class="indicator-label">{{__('lang.save')}}</span>
                                        <span class="indicator-progress">{{__('lang.wait')}} . . .
												<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                    {{--                                            <a href="{{route('admin.settings.products')}}" id="kt_ecommerce_add_product_cancel"--}}
                                    {{--                                               class="btn btn-light me-5">عودة</a>--}}
                                </div>
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
@endsection

@section('script')


@endsection

