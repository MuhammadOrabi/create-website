@php
    $section = $page->sections->where('title', 'Home')->first();
    $title = $section->contents->where('type', 'title')->first();
    $img = $section->contents->where('type', 'img')->first();
    $paragraph = $section->contents->where('type', 'paragraph')->first();
@endphp
<!--Section 1-->
@if($title)
    <div class="row sec section scrollspy" id="home">
        <div class="col l6 m6 s12 sec1_p_div">
            <h3>{{ $title->content }}</h3>
            <p class="p1">{{ $paragraph->content }}</p>
        </div>
        <div class="col l6 m6  hide-on-small-only"><img src="{{ $img->content }}" class="profile_pic2" ></div>
    </div>
@endif
<!--End Section 1-->