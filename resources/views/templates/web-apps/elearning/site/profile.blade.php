@extends($site->theme->location.'.layouts.site')

@section('content')
    <profile address="{{ $site->address }}"></profile>
@stop