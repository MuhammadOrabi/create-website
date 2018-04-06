@extends($site->theme->location . '.dashboard.layout')

@section('title')
    {{ $section->title }}
@stop

@section('content')
    <div class="columns">
        <div class="column is-one-quarter">
            <a class="subtitle" href="/dashboard/lessons/{{ $section->id }}/{{ $site->address }}">
                <span class="icon">
                    <i class="fa fa-arrow-left"></i>
                </span>
                Back to {{ $section->title }}
            </a>
        </div>
        <div class="column">
            <h1 class="title">Add a Item for {{$section->title}}</h1>            
        </div>
    </div>
    <items-cu c address="{{ $site->address }}" token="{{ auth()->user()->getToken('items-cu') }}" sectionid="{{ $section->id }}"></items-cu>
@stop