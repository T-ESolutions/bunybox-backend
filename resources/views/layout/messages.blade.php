@if(Session('success'))
    <!--begin::Alert-->
    <div class="alert alert-primary">
        <!--begin::Icon-->
{{--        <span class="svg-icon svg-icon-2hx svg-icon-primary me-3">...</span>--}}
        <!--end::Icon-->

        <!--begin::Wrapper-->
        <div class="d-flex flex-column">
            <!--begin::Title-->
            <h4 class="mb-1 text-dark">{{ Session('success') }}</h4>
            <!--end::Title-->
            <!--begin::Content-->
{{--            <span>The alert component can be used to highlight certain parts of your page for higher content visibility.</span>--}}
            <!--end::Content-->
        </div>
        <!--end::Wrapper-->
    </div>
@endif
@if(Session('danger'))
    <div class="alert alert-danger">
        <!--begin::Icon-->
{{--        <span class="svg-icon svg-icon-2hx svg-icon-danger me-3">...</span>--}}
        <!--end::Icon-->

        <!--begin::Wrapper-->
        <div class="d-flex flex-column">
            <!--begin::Title-->
            <h4 class="mb-1 text-dark">{{ Session('danger') }}</h4>
            <!--end::Title-->
            <!--begin::Content-->
        {{--            <span>The alert component can be used to highlight certain parts of your page for higher content visibility.</span>--}}
        <!--end::Content-->
        </div>
        <!--end::Wrapper-->
    </div>
@endif

