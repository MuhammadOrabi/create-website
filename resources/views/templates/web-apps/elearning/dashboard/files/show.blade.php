@extends($site->theme->location . '.layouts.dashboard')

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
            <h1 class="title">{{$section->title}}'s Files</h1>
        </div>
    </div>
    
    <files id="{{ $section->id }}" address="{{ $site->address }}" token="{{ auth()->user()->getToken('files-manage') }}"></files>        
@stop