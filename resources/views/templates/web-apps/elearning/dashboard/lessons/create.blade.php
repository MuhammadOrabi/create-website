@extends($site->theme->location . '.layouts.dashboard')

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
            <h1 class="title">Add a lesson for {{$section->title}}</h1>            
        </div>
    </div>
    <lessons-cu></lessons-cu>
@stop