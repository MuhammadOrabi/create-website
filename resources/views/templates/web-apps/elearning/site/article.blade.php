@extends($site->theme->location.'.layouts.site')

@section('content')
    <site-article id="{{ $id }}" address="{{ $site->address }}"></site-article>
@stop