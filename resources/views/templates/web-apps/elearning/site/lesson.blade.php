@extends($site->theme->location.'.layouts.site')

@section('content')
    <site-lesson id="{{ $id }}" address="{{ $site->address }}"></site-lesson>
@stop