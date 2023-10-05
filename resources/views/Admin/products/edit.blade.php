@extends('layout.layout')

@php
    $route = 'zones';
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
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">

        <!--begin::Form-->
        <form action="{{route('zones.update',$zone->id)}}" method="post" enctype="multipart/form-data"
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
                                        <h2>بيانات المنطقة</h2>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <!--begin::Card body-->
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <!--begin::Input group-->
                                            <div class="mb-10 fv-row">
                                                <!--begin::Label-->
                                                <label class="required form-label">اسم المنطقة</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="text" required name="name"
                                                       class="form-control mb-2" value="{{$zone->name}}"
                                                       placeholder="مثال : المنطقه الاولى"
                                                />
                                                <!--end::Input-->
                                                <!--begin::Description-->
                                            {{--                                                <div class="text-muted fs-7">A product name is required and recommended to be unique.</div>--}}
                                            <!--end::Description-->
                                            </div>
                                            <!--end::Input group-->

                                            <div class="mb-10 fv-row">
                                                <!--begin::Label-->
                                                <label class="required form-label">الإحداثيات (ارسم منطقتك على
                                                    الخريطة)</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <textarea type="text" rows="8" name="coordinates"
                                                          id="coordinates" class="form-control"
                                                          readonly>
{{--                                                            @foreach($zone->coordinates[0] as $key=>$coords)<?php if(count($zone->coordinates[0]) != $key+1) {if($key != 0) echo(','); ?>({{$coords->getLat()}}, {{$coords->getLng()}})<?php } ?>@endforeach--}}

                                                        </textarea>
                                                <!--end::Input-->
                                                <!--begin::Description-->
                                            {{--                                                <div class="text-muted fs-7">A product name is required and recommended to be unique.</div>--}}
                                            <!--end::Description-->
                                            </div>
                                            <!--end::Input group-->
                                        </div>
                                        <div class="col-md-7">
                                            <input id="pac-input" class="controls rounded"
                                                   style="height: 3em;width:fit-content;"
                                                   title="ابحث عن موقعك هنا" type="text" placeholder="بحث"/>
                                            <div id="map-canvas"
                                                 style="height: 100%; margin:0px; padding: 0px;"></div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Card header-->
                                <div class="card-footer">
                                    <button type="submit" id="kt_ecommerce_add_product_submit"
                                            class="btn btn-secondary">

                                        <span class="indicator-label">حفظ</span>
                                        <span class="indicator-progress">إنتظر قليلا . . .
												<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                    {{--                                            <a href="{{route('admin.settings.zones')}}" id="kt_ecommerce_add_product_cancel"--}}
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



    {{--    for map--}}
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAi4yKthIBU-bHeuQHPgpJmdXnuLxKGc1s&libraries=drawing,places&v=3.45.8"></script>

    <script>
        auto_grow();
        function auto_grow() {
            let element = document.getElementById("coordinates");
            element.style.height = "5px";
            element.style.height = (element.scrollHeight)+"px";
        }

    </script>
    <script>
        var map; // Global declaration of the map
        var lat_longs = new Array();
        var drawingManager;
        var lastpolygon = null;
        var bounds = new google.maps.LatLngBounds();
        var polygons = [];


        function resetMap(controlDiv) {
            // Set CSS for the control border.
            const controlUI = document.createElement("div");
            controlUI.style.backgroundColor = "#fff";
            controlUI.style.border = "2px solid #fff";
            controlUI.style.borderRadius = "3px";
            controlUI.style.boxShadow = "0 2px 6px rgba(0,0,0,.3)";
            controlUI.style.cursor = "pointer";
            controlUI.style.marginTop = "8px";
            controlUI.style.marginBottom = "22px";
            controlUI.style.textAlign = "center";
            controlUI.title = "Reset map";
            controlDiv.appendChild(controlUI);
            // Set CSS for the control interior.
            const controlText = document.createElement("div");
            controlText.style.color = "rgb(25,25,25)";
            controlText.style.fontFamily = "Roboto,Arial,sans-serif";
            controlText.style.fontSize = "10px";
            controlText.style.lineHeight = "16px";
            controlText.style.paddingLeft = "2px";
            controlText.style.paddingRight = "2px";
            controlText.innerHTML = "X";
            controlUI.appendChild(controlText);
            // Setup the click event listeners: simply set the map to Chicago.
            controlUI.addEventListener("click", () => {
                lastpolygon.setMap(null);
                $('#coordinates').val('');

            });
        }

        function initialize() {
            var myLatlng = new google.maps.LatLng({{trim(explode(' ',$zone->center)[1], 'POINT()')}}, {{trim(explode(' ',$zone->center)[0], 'POINT()')}});
            var myOptions = {
                zoom: 13,
                center: myLatlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);

            const polygonCoords = [

                    @foreach($zone->coordinates[0] as $coords)
                { lat: {{$coords->getLat()}}, lng: {{$coords->getLng()}} },
                @endforeach
            ];

            var zonePolygon = new google.maps.Polygon({
                paths: polygonCoords,
                strokeColor: "#050df2",
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillOpacity: 0,
            });

            zonePolygon.setMap(map);

            zonePolygon.getPaths().forEach(function(path) {
                path.forEach(function(latlng) {
                    bounds.extend(latlng);
                    map.fitBounds(bounds);
                });
            });


            drawingManager = new google.maps.drawing.DrawingManager({
                drawingMode: google.maps.drawing.OverlayType.POLYGON,
                drawingControl: true,
                drawingControlOptions: {
                    position: google.maps.ControlPosition.TOP_CENTER,
                    drawingModes: [google.maps.drawing.OverlayType.POLYGON]
                },
                polygonOptions: {
                    editable: true
                }
            });
            drawingManager.setMap(map);

            google.maps.event.addListener(drawingManager, "overlaycomplete", function(event) {
                var newShape = event.overlay;
                newShape.type = event.type;
            });

            google.maps.event.addListener(drawingManager, "overlaycomplete", function(event) {
                if(lastpolygon)
                {
                    lastpolygon.setMap(null);
                }
                $('#coordinates').val(event.overlay.getPath().getArray());
                lastpolygon = event.overlay;
                auto_grow();
            });
            const resetDiv = document.createElement("div");
            resetMap(resetDiv, lastpolygon);
            map.controls[google.maps.ControlPosition.TOP_CENTER].push(resetDiv);

            // Create the search box and link it to the UI element.
            const input = document.getElementById("pac-input");
            const searchBox = new google.maps.places.SearchBox(input);
            map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);
            // Bias the SearchBox results towards current map's viewport.
            map.addListener("bounds_changed", () => {
                searchBox.setBounds(map.getBounds());
            });
            let markers = [];
            // Listen for the event fired when the user selects a prediction and retrieve
            // more details for that place.
            searchBox.addListener("places_changed", () => {
                const places = searchBox.getPlaces();

                if (places.length == 0) {
                    return;
                }
                // Clear out the old markers.
                markers.forEach((marker) => {
                    marker.setMap(null);
                });
                markers = [];
                // For each place, get the icon, name and location.
                const bounds = new google.maps.LatLngBounds();
                places.forEach((place) => {
                    if (!place.geometry || !place.geometry.location) {
                        console.log("Returned place contains no geometry");
                        return;
                    }
                    const icon = {
                        url: place.icon,
                        size: new google.maps.Size(71, 71),
                        origin: new google.maps.Point(0, 0),
                        anchor: new google.maps.Point(17, 34),
                        scaledSize: new google.maps.Size(25, 25),
                    };
                    // Create a marker for each place.
                    markers.push(
                        new google.maps.Marker({
                            map,
                            icon,
                            title: place.name,
                            position: place.geometry.location,
                        })
                    );

                    if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                });
                map.fitBounds(bounds);
            });
        }
        google.maps.event.addDomListener(window, 'load', initialize);


    </script>


@endsection

