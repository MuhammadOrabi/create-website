@php
    $links = $constant->contents->where('type', 'links')->first();
    $paragraph = $constant->contents->where('type', 'paragraph')->first();
@endphp
<footer class="page-footer">
    <div class="container">
        <div class="row">
            <div class="col l6 s12">
                <h5 class="white-text">{{ $site->name }}</h5>
                @if($paragraph && $paragraph->active)
                    <p class="grey-text text-lighten-4">{{ $paragraph->content }}</p>
                @endif
            </div>
            <div class="col l4 offset-l2 s12">
                @if($links && $links->active)
                    <h5 class="white-text">Links</h5>
                    <ul>
                        @foreach($links->extras as $link)
                        <li>
                            <a class="grey-text text-lighten-3" style="text-transform:capitalize" href="{{ $link->content }}">{{ $link->type }}</a>
                        </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            © 2018 Copyright
        </div>
    </div>
</footer>