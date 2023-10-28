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
    </ul>


    <!--end::Breadcrumb-->
@endsection

@section('content')
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Products-->
            <div class="card card-flush">
                <!--begin::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="admins_table">
                        <!--begin::Table head-->
                        <thead>
                        <!--begin::Table row-->
                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                            {{--                                <th class="w-10px pe-2">--}}
                            {{--                                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">--}}
                            {{--                                        <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_ecommerce_products_table .form-check-input" value="1" />--}}
                            {{--                                    </div>--}}
                            {{--                                </th>--}}
                            <th class=" min-w-1px">#</th>
                            <th class=" min-w-1px">{{__('lang.orders')}}</th>
                            <th class=" min-w-1px">{{__('lang.status')}}</th>
                            <th class=" min-w-1px">{{__('lang.payment_status')}}</th>
                            <th class=" min-w-1px">{{__('lang.payment_method')}}</th>
                            <th class=" min-w-1px">{{__('lang.users')}}</th>
                            <th class=" min-w-1px">{{__('lang.boxes')}}</th>
                            <th class=" min-w-1px">{{__('lang.price')}}</th>
                            <th class=" min-w-1px">{{__('lang.shipping')}}</th>
                            <th class=" min-w-1px">{{__('lang.total_price')}}</th>
                            <th class=" min-w-1px">{{__('lang.created_at')}}</th>
                            <th class=" min-w-1px">{{__('lang.delivered_at')}}</th>
                            <th class="min-w-1px">{{__('lang.Actions')}}</th>

                        </tr>
                        <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="fw-bold text-gray-600">

                        </tbody>
                        <!--end::Table body-->
                    </table>
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Products-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->

@endsection

@section('script')
    <script src="{{ URL::asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>

    <script type="text/javascript">
        $(function () {
            var table = $('#admins_table').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                responsive: true,
                aaSorting: [],
                "dom": "<'card-header border-0 p-0 pt-6'<'card-title' <'d-flex align-items-center position-relative my-1'f> r> <'card-toolbar' <'d-flex justify-content-end add_button'B> r>>  <'row'l r> <''t><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
                lengthMenu: [[10, 25, 50, 100, 250, -1], [10, 25, 50, 100, 250, "الكل"]],
                "language": {
                    url: "@if(Session('lang')  ==  'ar') //cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json @endif",
                    search: '<i class="fa fa-eye" aria-hidden="true"></i>',
                    searchPlaceholder: 'Search'
                },
                buttons: [
                    {
                        extend: 'colvis',
                        text: '{{__('lang.Show column')}}',
                        title: '',

                        className: 'btn btn-primary me-3',
                        customize: function (win) {
                            $(win.document).css('direction', '{{__('lang.lang-direction')}}');
                        }
                    },

                    {
                        extend: 'print',
                        className: 'btn btn-primary me-3',
                        text: '<i class="bi bi-printer-fill fs-2x"></i>',
                        titleAttr: "{{__('lang.print')}}",
                        customize: function (win) {
                            $(win.document.body)
                                .css('direction', '{{__('lang.lang-direction')}}').prepend(
                                ' <table> ' +
                                '                        <tbody> ' +
                                '                                <tr>' +
                                '                                    <td style="text-align: center">  <p style="padding-right:150px">Bunny Box</p></td>' +
                                '                                    <td style="text-align: right"> <img src="{{asset('logo.png')}}" width="150px" height="150px" /> </td>' +
                                '                                    <td style="text-align: right"><p>{{__("lang.title")}} : {{__('lang.'.$route)}}</p>' +
                                '                                                                  <p>{{__('lang.date')}} : {{ Carbon\Carbon::now()->translatedFormat('l Y/m/d') }}</p>' +
                                '                                                                  <p>{{__('lang.time')}} : {{ Carbon\Carbon::now()->translatedFormat('h:i a') }}</p></td>' +
                                '                                </tr> ' +
                                '                        </tbody>' +
                                '                    </table>'
                            );
                        },

                        exportOptions: {
                            columns: [0, ':visible'],
                            stripHtml: false
                        }
                    },

                    // {extend: 'pdf', className: 'btn btn-raised btn-danger', text: 'PDF'},
                    {
                        extend: 'excel',
                        className: 'btn btn-primary me-3',
                        text: '<i class="bi bi-file-earmark-spreadsheet-fill fs-2x"></i> ',
                        title: '',
                        titleAttr: "{{__('lang.excel')}}",
                        customize: function (win) {
                            $(win.document)
                                .css('direction', 'rtl');
                        },
                        exportOptions: {
                            columns: [0, ':visible']
                        }
                    },

                    // {extend: 'colvis', className: 'btn secondary', text: 'إظهار / إخفاء الأعمدة '}
                ],
                ajax: {
                    url: '{{ route($route.'.datatable') }}',
                    data: {}
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', "searchable": false, "orderable": false},
                    {"data": "id", "searchable": true, "orderable": false},
                    {"data": "status", "searchable": false, "orderable": false},
                    {"data": "payment_status", "searchable": false, "orderable": false},
                    {"data": "payment_method", "searchable": false, "orderable": false},
                    {"data": "user_name", "searchable": false, "orderable": false},
                    {"data": "box", "searchable": false, "orderable": false},
                    {"data": "price", "searchable": false, "orderable": false},
                    {"data": "shipping_cost", "searchable": false, "orderable": false},
                    {"data": "total", "searchable": false, "orderable": false},
                    {"data": "created_at", "searchable": true, "orderable": false},
                    {"data": "delivered_at", "searchable": true, "orderable": false},
                    {"data": 'actions', name: 'actions', orderable: false, searchable: false}
                ]
            });
            $.ajax({
                url: "{{ URL::to($route.'/add-button')}}",
                success: function (data) {
                    $('.add_button').append(data);
                },
                dataType: 'html'
            });
        });
    </script>


@endsection

