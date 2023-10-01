<div
    class="form-check form-switch form-check-custom form-check-solid">

    <input class="form-check-input" name="status" type="hidden"
           value="inactive" id="flexSwitchDefault"/>
    <input
        class="form-check-input form-control form-control-solid mb-3 mb-lg-0"
        onchange="update_active(this,'{{route('speakers.change_active')}}')"
        value="{{ $id }}" name="status" type="checkbox" @if($status == 'active') checked @endif
        id="flexSwitchDefault"/>
</div>
