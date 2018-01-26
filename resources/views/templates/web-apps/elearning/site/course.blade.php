@extends($site->theme->location.'.layouts.site')

@section('content')
    <site-course id="{{ $id }}" address="{{ $site->address }}"></site-course>
@stop