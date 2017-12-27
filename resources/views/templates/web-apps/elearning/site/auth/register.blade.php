@extends($site->theme->location.'.layouts.site')

@section('content')
    <site-register address="{{$site->address}}"></site-register>
@stop