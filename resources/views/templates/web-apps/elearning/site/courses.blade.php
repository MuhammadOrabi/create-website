@extends($site->theme->location.'.layouts.site')

@section('content')
    <div class="container columns">
        <div class="column is-one-fifth"></div>
        <div class="column">
            <site-courses address="{{ $site->address }}" id="{{ $page->id }}"></site-courses>
        </div>        
    </div>
@stop