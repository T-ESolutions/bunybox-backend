{{--@if(request()->segment(1) != 'ready' && request()->segment(1) != 'cars') active show @endif--}}
<div class="tab-pane fade
    @if( request()->segment(1) == 'orders' ) active show
    @endif" id="kt_aside_nav_tab_menu_orders"
     role="tabpanel">
    <div
        class="menu menu-column menu-fit menu-rounded menu-title-gray-600 menu-icon-gray-400 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-bold fs-5 px-6 my-5 my-lg-0"
        id="kt_aside_menu" data-kt-menu="true">
        <div id="kt_aside_menu_wrapper" class="menu-fit">
            <div class="menu-item">
                <div class="menu-content pb-2">
                    <h2 class="subheader-title text-dark font-weight-bold my-1 mr-3">
                        {{trans('lang.orders')}}
                    </h2>
                </div>
            </div>
            <div class="menu-item">
                <a class="menu-link @if(request()->routeIs('orders.*')) active @endif "
                   href="{{url('/orders')}}">
                    <i class="fa fa-cart-plus p-3 text-primary"></i>
                    <span class="menu-title">{{__('lang.orders')}}</span>
                </a>
            </div>


            </a>
        </div>
    </div>
</div>
