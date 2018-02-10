@php
    $section = $page->sections->where('title', 'Left Show Case')->first();
    $img = $section->contents->where('type', 'img')->first();
    $title = $section->contents->where('type', 'title')->first();
    $subtitle = $section->contents->where('type', 'subtitle')->first();
    $facebook = $section->contents->where('type', 'facebook')->first();
    $github = $section->contents->where('type', 'github')->first();
    $twitter = $section->contents->where('type', 'twitter')->first();
    $linkedin = $section->contents->where('type', 'linkedin')->first();
@endphp

    <!--Side-left section-->
<div class="col l3 hide-on-small hide-on-med-and-down">
    @if($section->contents->isNotEmpty())
        <!-- ========== ========== fixed - left side body start ========== ========== -->
        <div class="fixed-left-side-body">
            <div class="profile">
                @if($img->content)
                    <div class="profile-image center-align">
                        <img src="{{ $img->content }}" alt="Image">
                    </div>
                @endif
                <!-- /.profile-image -->
                <div class="profile-name center-align">
                    @if($title->content)
                        <h1 class="user-name">{{ $title->content }}</h1>
                    @endif
                    @if($subtitle->content)
                        <p class="name_p">
                            <span class="photoshop-color">{{ $subtitle->content }}</span>
                        </p>
                    @endif
                </div>
                <!-- /.profile-name -->
                <ul class="social-btn">
                    @if($facebook->content)
                        <li><a href="{{ $facebook->content }}" target="_blank" ><i class="fa fa-facebook fa-2x " aria-hidden="true"></i></a></li>
                    @endif
                    @if($twitter->content)
                        <li><a href="{{ $twitter->content }}" target="_blank" ><i class="fa fa-twitter fa-2x " aria-hidden="true"></i></a></li>
                    @endif
                    @if($github->content)
                        <li><a href="{{ $github->content }}" target="_blank" ><i class="fa fa-github fa-2x " aria-hidden="true"></i></a></li>
                    @endif
                    @if($linkedin->content)
                        <li><a href="{{ $linkedin->content }}" target="_blank" ><i class="fa fa-linkedin fa-2x " aria-hidden="true"></i></a></li>
                    @endif
                </ul>
            </div>
            <!-- /.profile -->
        </div>
        <!-- /.fixed-left-side-body -->
    @endif
</div><!--End Side-left section-->