@extends($site->theme->location.'.layouts.site')

@section('content')
   <site-home id="{{ $page->id }}" address="{{ $site->address }}"></site-home>
@stop