@extends($site->theme->location . '.site.layout') @section('content')
<div class="col l9 s12">
    <div id="box">
        <div class="row load">
            @foreach($component->contents->sortByDesc('created_at') as $content)
                <div class="col l4 s12 m7">
                    <div class="card">
                        <div class="card-image">
                            <img src="{{ $content->extras->where('type', 'img')->first()->content }}">
                        </div>
                        <div class="card-content">
                            <p>{{ $content->title }}</p>
                        </div>
                        <a class="read_more_btn" href="/s/{{ $site->address }}/item/{{ $content->id }}">
                            <div class="card-action">Read more</div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@stop