@extends('layout.layout')

@php
    $route = 'boxes';
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
                                                <div class="image-input image-input-empty image-input-outline mb-3" data-kt-image-input="true" style="">
                                                    <!--begin::Preview existing avatar-->
                                                    <div class="image-input-wrapper w-150px h-150px" style="background-image: url({{$row->image}})"></div>
                                                    <!--end::Preview existing avatar-->
                                                    <!--begin::Label-->
                                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="إختر الصورة">
                                                        <i class="bi bi-pencil-fill fs-7"></i>
                                                        <!--begin::Inputs-->
                                                        <input  type="file" name="image" accept=".png, .jpg, .jpeg" />
                                                        <input type="hidden"  />
                                                        <!--end::Inputs-->
                                                    </label>
                                                    <!--end::Label-->
                                                    <!--begin::Cancel-->
                                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="إلغاء الصورة">
														<i class="bi bi-x fs-2"></i>
													</span>
                                                    <!--end::Cancel-->
                                                    <!--begin::Remove-->
                                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="حذف الصورة">
														<i class="bi bi-x fs-2"></i>
													</span>
                                                    <!--end::Remove-->
                                                </div>
                                                <!--end::Image input-->
                                                <!--begin::Description-->
                                                <div class="text-danger fs-7"> *.png - *.jpg - *.jpeg </div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Card body-->
                                            <!--end::Thumbnail settings-->

                                            <!--begin::Input group-->
                                            <div class="mb-5 fv-row">
                                                <!--begin::Label-->
                                                <label class="required form-label">
                                                    {{__('lang.main_categories')}}
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <select class="form-control mb-2" name="main_category_id" data-control="select2" data-hide-search="false">
                                                    @foreach($main_categories as $main_category)
                                                        <option value="{{$main_category->id}}" {{$main_category->id == $row->main_category_id ? 'selected' : ''}}>{{$main_category->title}}</option>
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
                                                <label class="required form-label">{{__('lang.price')}}
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="number" min="1" required name="price"
                                                       class="form-control mb-2" value="{{$row->price}}"
                                                       placeholder="{{__('lang.price')}} "
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
                                                <label class="required form-label">{{__('lang.min_price')}}
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="number" min="1" required name="min_price"
                                                       class="form-control mb-2" value="{{$row->min_price}}"
                                                       placeholder="{{__('lang.min_price')}} "
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
                                                <label class="required form-label">{{__('lang.max_price')}}
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="number" min="1" required name="max_price"
                                                       class="form-control mb-2" value="{{$row->max_price}}"
                                                       placeholder="{{__('lang.max_price')}} "
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

                                            <!--begin::Input group-->
                                            <div class="mb-5 fv-row">
                                                <!--begin::Label-->
                                                <label class="required form-label">
                                                    {{__('lang.categories')}}
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <select required class="form-control mb-2" name="category_id[]" data-control="select2" data-hide-search="false" multiple>
                                                    @foreach($categories as $category)
                                                        <option value="{{$category->id}}" {{in_array($category->id,$boxCategories) ? 'selected' : ''}}>{{$category->title}}</option>
                                                    @endforeach
                                                </select>
                                                <!--end::Input-->
                                                <!--begin::Description-->
                                            {{--                                                <div class="text-muted fs-7">A product name is required and recommended to be unique.</div>--}}
                                            <!--end::Description-->
                                            </div>
                                            <!--end::Input group-->

                                        </div>
                                        <div class="col-md-6">
                                            <!--begin::Thumbnail settings-->
                                            <div class="text-center pt-0">
                                                <!--begin::Image input-->
                                                <div class="image-input image-input-empty image-input-outline mb-3"
                                                     data-kt-image-input="true"
                                                     @if($row->slider_image_ar) style="background-image: url({{ $row->slider_image_ar}})" @else style="background-image: url(assets/media/svg/files/blank-image.svg)" @endif>
                                                    <!--begin::Preview existing avatar-->
                                                    <div class="image-input-wrapper w-150px h-150px"></div>
                                                    <!--end::Preview existing avatar-->
                                                    <!--begin::Label-->
                                                    <label
                                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                        data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                                        title="{{trans('lang.choose_image')}}">
                                                        <i class="bi bi-pencil-fill fs-7"></i>
                                                        <!--begin::Inputs-->
                                                        <input type="file" name="slider_image_ar"
                                                               accept=".png, .jpg, .jpeg"/>
                                                        <input type="hidden" name="avatar_remove"/>
                                                        <!--end::Inputs-->
                                                    </label>
                                                    <!--end::Label-->
                                                    <!--begin::Cancel-->
                                                    <span
                                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                        data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                                        title="{{trans('lang.cancel_image')}}">
														<i class="bi bi-x fs-2"></i>
													</span>
                                                    <!--end::Cancel-->
                                                    <!--begin::Remove-->
                                                    <span
                                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                        data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                                        title="{{trans('lang.remove_image')}}">
														<i class="bi bi-x fs-2"></i>
													</span>
                                                    <!--end::Remove-->
                                                </div>
                                                <!--end::Image input-->
                                                <!--begin::Description-->
                                                <div class="text-dark fs-7 form-label" style="font-weight: bolder;">
                                                    {{trans('lang.slider_image_ar')}}
                                                </div>
                                                <div class="text-danger fs-7"> *.png - *.jpg - *.jpeg</div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Thumbnail settings-->
                                        </div>
                                        <div class="col-md-6">
                                            <!--begin::Thumbnail settings-->
                                            <div class="text-center pt-0">
                                                <!--begin::Image input-->
                                                <div class="image-input image-input-empty image-input-outline mb-3"
                                                     data-kt-image-input="true"
                                                     style="background-image: url({{$row->slider_image_en ? $row->slider_image_en : 'assets/media/svg/files/blank-image.svg' }})">
                                                    <!--begin::Preview existing avatar-->
                                                    <div class="image-input-wrapper w-150px h-150px"></div>
                                                    <!--end::Preview existing avatar-->
                                                    <!--begin::Label-->
                                                    <label
                                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                        data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                                        title="{{trans('lang.choose_image')}}">
                                                        <i class="bi bi-pencil-fill fs-7"></i>
                                                        <!--begin::Inputs-->
                                                        <input type="file" name="slider_image_en"
                                                               accept=".png, .jpg, .jpeg"/>
                                                        <input type="hidden" name="avatar_remove"/>
                                                        <!--end::Inputs-->
                                                    </label>
                                                    <!--end::Label-->
                                                    <!--begin::Cancel-->
                                                    <span
                                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                        data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                                        title="{{trans('lang.cancel_image')}}">
														<i class="bi bi-x fs-2"></i>
													</span>
                                                    <!--end::Cancel-->
                                                    <!--begin::Remove-->
                                                    <span
                                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                        data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                                        title="{{trans('lang.remove_image')}}">
														<i class="bi bi-x fs-2"></i>
													</span>
                                                    <!--end::Remove-->
                                                </div>
                                                <!--end::Image input-->
                                                <!--begin::Description-->
                                                <div class="text-dark fs-7 form-label" style="font-weight: bolder;">
                                                    {{trans('lang.slider_image_en')}}
                                                </div>
                                                <div class="text-danger fs-7"> *.png - *.jpg - *.jpeg</div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Thumbnail settings-->
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

