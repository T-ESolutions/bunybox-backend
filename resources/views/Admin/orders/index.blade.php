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

    <!--begin::Modal - change status-->
    <div class="modal fade" id="kt_modal_create_app" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Status-->
                <div class="card card-flush py-4">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <!--begin::Card title-->
                        <div class="card-title text-center">
                            <h2>{{__('lang.change_status')}}</h2>
                            &nbsp;
                            &nbsp;
                            -
                            &nbsp;
                            &nbsp;
                            <h2 class="text-center">{{__('lang.order_status')}}
                                &nbsp;
                                :
                                &nbsp;
                            </h2>
                            <h2 id="statusText" class="text-primary text-center"></h2>
                        </div>
                        <!--end::Card title-->
                        <!--begin::Close-->
                        <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                            <span class="svg-icon svg-icon-1">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none">
									<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                          transform="rotate(-45 6 17.3137)" fill="black"/>
									<rect x="7.41422" y="6" width="16" height="2" rx="1"
                                          transform="rotate(45 7.41422 6)" fill="black"/>
								</svg>
							</span>
                            <!--end::Svg Icon-->
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <form id="submit_btn" method="post" action="{{route('orders.changeOrderStatus')}}">
                        @csrf
                        <input type="hidden" name="row_id" id="row_id">
                        <div class="card-body pt-0">
                            <!--begin::Select2-->
                            <div class="row">
                                <div class="col-lg-6">
                                    <select name="status" required class="form-select mb-2" data-control="select2"
                                            data-hide-search="true" data-placeholder="{{__('lang.choose_status')}}"
                                            id="kt_ecommerce_add_product_status_select">
                                        <option></option>
                                        <option value="ordered">
                                            ordered
                                        </option>
                                        <option value="shipped">
                                            shipped
                                        </option>
                                        <option value="delivered">
                                            delivered
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <!--end::Select2-->
                        </div>
                        <!--end::Card body-->
                        <div class="modal-footer">
                            <button type="submit" data-dismiss="modal" class="btn btn-primary submit_btn">تأكيد</button>
                        </div>
                    </form>
                </div>
                <!--end::Status-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - change status-->

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
                                '                                    <td style="text-align: right"> <img src="{{asset('logo/logo.png')}}" width="150px" height="150px" /> </td>' +
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

    <script>
        $(document).on("click", ".changeStatus", function () {
            var row_id = $(this).data('id');
            var status_val = $(this).data('status');
            $(".card #row_id").val(row_id);

            if(status_val == 'delivered'){
                $(".card #statusText").html("delivered");
            }else if(status_val == 'shipped'){
                $(".card #statusText").html("shipped");
            }else if(status_val == 'ordered'){
                $(".card #statusText").html("ordered");
            }
        });

        $('.submit_btn').on('click', function () {
            $('#submit_btn').submit();
        })
    </script>

@endsection

