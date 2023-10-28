@php
    $route = 'orders';
@endphp

<div class="dt-buttons flex-wrap">
    <!--end::Filter-->
    <!--begin::Add user-->

{{--    <a href="{{route("$route.create")}}" class="btn btn-light-primary me-3"> <i--}}
{{--            class="bi bi-plus-circle-fill fs-2x"></i> </a>--}}

{{--    <!--end::Add user-->--}}
{{--    <button id="delete" class="btn btn-light-danger me-3 font-weight-bolder">--}}
{{--        <i class="bi bi-trash-fill fs-2x"></i>--}}
{{--    </button>--}}
</div>
<!--end::Page Custom Javascript-->

<script type="text/javascript">

    $("#delete").on("click", function () {
        var dataList = [];
        $("#admins_table .selector:checked").each(function (index) {
            dataList.push($(this).val())
        })
        if (dataList.length > 0) {
            Swal.fire({
                title: "{{__('lang.warrning')}} !",
                text: "",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#f64e60",
                confirmButtonText: "{{__('lang.btn_yes')}}",
                cancelButtonText: "{{__('lang.btn_no')}}",
                closeOnConfirm: false,
                closeOnCancel: false
            }).then(function (result) {
                if (result.value) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: '{{route($route.".delete")}}',
                        type: "get",
                        data: {'id': dataList, _token: CSRF_TOKEN},
                        dataType: "JSON",
                        success: function (data) {
                            if (data.message == "Success") {
                                $("#admins_table .selector:checked").parents("tr").remove();
                                Swal.fire("{{__('lang.Success')}}", "{{__('lang.Success_text')}}", "success");
                                // location.reload();
                            } else {
                                Swal.fire("{{__('lang.Sorry')}}", "{{__('lang.operation_failed')}}", "error");
                            }
                        },
                        fail: function (xhrerrorThrown) {
                            Swal.fire("{{__('lang.Sorry')}}", "{{__('lang.operation_failed')}}", "error");
                        }
                    });
                    // result.dismiss can be 'cancel', 'overlay',
                    // 'close', and 'timer'
                } else if (result.dismiss === 'cancel') {
                    Swal.fire("{{__('lang.Sorry')}}", "{{__('lang.Cancelled')}}", "error");
                }
            });
        } else {
            Swal.fire("{{__('lang.Sorry')}}", "{{__('lang.please choose at least one item')}}", "error");

        }
    });
</script>
