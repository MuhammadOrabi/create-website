@extends($site->theme->location . '.layouts.dashboard')

@section('title')
    {{ $page->title }}
@stop

@section('content')
    <h1 class="title">{{ $page->title }}</h1>
    @if($page->title === 'Users')
        <users address="{{ $site->address }}" token="{{ auth()->user()->getToken('users-manage') }}"></users>
    @elseif($page->title === 'Courses')
        <courses id="{{ $page->id }}" address="{{ $site->address }}" token="{{ auth()->user()->getToken('courses-manage') }}"></courses>
    @endif
@stop