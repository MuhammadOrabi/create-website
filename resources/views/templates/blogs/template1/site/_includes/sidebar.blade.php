<div class="col l3 hide-on-small-only right_section">
    @foreach($pages->sortByDesc('created_at') as $page)
        <ul class="tabs">
            <li class="tab col l12 top_movies_li">Top {{ $page->title }}</li>
        </ul>
        <div class="side">
            @foreach($page->contents->sortByDesc('created_at') as $content)
                <div class="row ">
                    <a href="/s/{{ $site->address }}/item/{{ $content->id }}">
                        <div class="col l5 ">
                            <img class="side_img" src="{{ $content->extras->where('type', 'img')->first()->content }}">
                        </div>
                        <div class="col l7 ">
                            <p class="description">{{ $content->title }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @endforeach
</div>