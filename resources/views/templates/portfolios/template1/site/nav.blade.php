<!-- Navbars goes here -->
<nav>
    <div class="nav-wrapper">
        <a href="#" data-activates="slide-out" class="button-collapse"> <i class="material-icons">dehaze</i></a>
        <ul class=" hide-on-med-and-down section">
            @foreach($sections as $section)
                <li><a href="#{{ str_slug($section->title) }}" class="hvr-shutter-out-horizontal waves-effect white-text">{{ $section->title }}</a></li>
            @endforeach
        </ul>
    </div><!--end nav-wrapper-->
</nav><!--End Navbars -->
<!-- Side nav-->                
<ul id="slide-out" class="side-nav">
    @foreach($sections as $section)
        <li><a href="#{{ str_slug($section->title) }}" class="waves-effect">{{ $section->title }}</a></li>
    @endforeach
</ul>
<!-- end Side nav-->