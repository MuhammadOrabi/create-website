@extends($site->theme->location.'.layouts.site')

@section('content')
    <site-about address="{{ $site->address }}"></site-about>
@stop