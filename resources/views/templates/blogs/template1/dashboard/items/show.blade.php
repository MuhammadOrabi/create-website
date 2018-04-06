@extends($site->theme->location . '.dashboard.layout')

@section('title')
    {{$section->title}}
@stop

@section('content')
    <div class="columns">
        <div class="column is-one-quarter">
            <a class="subtitle" href="/dashboard/pages/{{ $page->id }}/{{ $site->address }}">
                <span class="icon">
                    <i class="fa fa-arrow-left"></i>
                </span>
                Back to {{ $page->title }}
            </a>
        </div>
        <div class="column">
            <h1 class="title">{{$section->title}}'s Items</h1>
        </div>
    </div>
    
    <items id="{{ $section->id }}" address="{{ $site->address }}" token="{{ auth()->user()->getToken('items-manage') }}"></items>        
@stop