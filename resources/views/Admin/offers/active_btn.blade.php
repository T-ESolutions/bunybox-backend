<div
    class="form-check form-switch form-check-custom form-check-solid">

    <input class="form-check-input" name="active" type="hidden"
           value="inactive" id="flexSwitchDefault"/>
    <input
        class="form-check-input form-control form-control-solid mb-3 mb-lg-0"
        onchange="update_active(this,'{{route('boxes.change_active')}}')"
        value="{{ $id }}" name="active" type="checkbox" @if($active == 1 ) checked @endif
        id="flexSwitchDefault"/>
</div>
