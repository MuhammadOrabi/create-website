@extends($site->theme->location . '.site.layout') 
@section('title') 
    {{ $site->name }}
@stop 
@php
    $page = $site->pages->where('slug', 'page')->first();
    $contents = $page->contents->sortByDesc('created_at');
@endphp
@section('content')
<div class="col l9 s12">

    <!--slider-->
    <div class="slider">
        <ul class="slides">
            @foreach($contents as $content)
                <li>
                    <a href="/s/{{ $site->address }}/item/{{ $content->id }}">
                        <img src="{{ @$content->extras->where('type', 'img')->first()->content }}">
                        <div class="caption center-align">
                            <h3>{{ $content->title }}</h3>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    <!--end slider -->

    <!--LATEST MOVIE NEWS HEADLINES-->
    <div id="box">
        <div class="heading">LATEST HEADLINES</div>
        <div class="trapezoid"></div>
        <!-- cards-->
        @php $key = ($contents->count() / 3) > 5 ? 5 : ($contents->count() / 3) + 1 @endphp
        @for ($i = 1; $i < $key; $i++)
            <div class="row load">
                @php $chunk = $contents->forPage($i, 3); @endphp
                @foreach($chunk as $content)
                    <div class="col l4 s12 m7">
                        <div class="card">
                            <div class="card-image">
                                <img src="{{ @$content->extras->where('type', 'img')->first()->content }}">
                            </div>
                            <div class="card-content">
                                <p>{{ $content->title }}</p>
                            </div>
                            <a class="read_more_btn" href="/s/{{ $site->address }}/item/{{ $content->id }}">
                                <div class="card-action">
                                    Read more
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endfor
        <!-- ^^^^ -->
        <a class="lm_btn" href="#" id="loadMore">Load More</a>
    </div>

    <!-- END LATEST MOVIE NEWS HEADLINES-->


</div>
@stop