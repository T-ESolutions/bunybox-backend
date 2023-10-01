@foreach($data as $speaker)
    <option value="{{$speaker->id}}">{{$speaker->name}}</option>
@endforeach
