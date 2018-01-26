@extends($site->theme->location.'.layouts.site')

@section('content')
    <div class="container columns">
        <div class="column is-one-fifth"></div>
        <div class="column">
            <site-articles address="{{ $site->address }}" id="{{ $page->id }}"></site-articles>
        </div>        
    </div>
@stop