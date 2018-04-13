<nav>
    <div class="nav-wrapper">
        <a href="#" data-activates="mobile-demo" class="button-collapse">
            <i class="material-icons">menu</i>
        </a>
        <ul class="left hide-on-med-and-down">
            <li>
                <a href="/s/{{ $site->address }}">{{ $site->name }}</a>
            </li>
            @foreach($pages as $page)
                <li>
                    <a href="/s/{{ $site->address }}/page/{{ $page->id }}">{{ $page->title }}</a>
                </li>
            @endforeach
        </ul>
        <ul class="side-nav" id="mobile-demo">
            @foreach($pages as $page)
                <li>
                    <a href="/s/{{ $site->address }}/page/{{ $page->id }}">{{ $page->title }}</a>
                </li>
            @endforeach
        </ul>
    </div>
</nav>
