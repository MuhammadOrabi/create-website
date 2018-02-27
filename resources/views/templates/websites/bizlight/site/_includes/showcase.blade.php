@if($showCase->contents->isNotEmpty())
    @php
        $image = $showCase->contents->where('type', 'img')->first();
        $heading = $showCase->contents->where('type', 'heading')->first();
        $paragraph = $showCase->contents->where('type', 'paragraph')->first();
    @endphp
    @if($image)
        <div class="showcase" style="background: url( {{ $image->content }} ) no-repeat 0 ;background-position: center; background-size: cover;">
    @else
        <div class="showcase" style="background: #d6d6d6">
    @endif
        <div class="container">
            @if($heading)
                <h1>{{ $heading->content }}</h1>
            @endif
            @if($paragraph)
                <p class="lead">
                    {{ $paragraph->content }}
                </p>
            @endif
            <a href="/s/{{$site->address}}/about" class="btn btn-primary">Read More</a>
        </div>
    </div>
@endif