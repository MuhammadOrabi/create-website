@extends($site->theme->location . '.dashboard.layout')
@section('title')
    {{ $section->title }}
@stop
@section('content')
    <h1 class="title">{{ $section->title }}</h1>
    @if($section->title === 'Home')
        <home id="{{ $section->id }}" token="{{ auth()->user()->getToken('manage-home') }}" address="{{ $site->address }}"></home>
    @elseif($section->title === 'About')
        <about id="{{ $section->id }}" token="{{ auth()->user()->getToken('manage-about') }}" address="{{ $site->address }}"></about>
    @elseif($section->title === 'Skill')
        <skill id="{{ $section->id }}" token="{{ auth()->user()->getToken('manage-skill') }}" address="{{ $site->address }}"></skill>
    @elseif($section->title === 'Education')
        <education id="{{ $section->id }}" token="{{ auth()->user()->getToken('manage-education') }}" address="{{ $site->address }}"></education>
    @elseif($section->title === 'Experience')
        <experience id="{{ $section->id }}" token="{{ auth()->user()->getToken('manage-experience') }}" address="{{ $site->address }}"></experience>
    @elseif($section->title === 'Contact')
        <contact id="{{ $section->id }}" token="{{ auth()->user()->getToken('manage-contact') }}" address="{{ $site->address }}"></contact>
    @elseif($section->title === 'Left Show Case')
        <left-show-case id="{{ $section->id }}" token="{{ auth()->user()->getToken('manage-left-show-case') }}" address="{{ $site->address }}"></left-show-case>
    @endif
@stop