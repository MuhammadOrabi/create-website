@extends($site->theme->location . '.site.layout') 
@section('content')
<div class="col l9 s12">
    <!-- slider-->
    <div class="slider">
        <ul class="slides">
            @foreach($component->extras->where('type', 'img') as $img)
                <li>
                    <img src="{{ $img->content }}">
                    <div class="caption center-align"></div>
                </li>
            @endforeach
        </ul>
    </div>
    <!-- end slider -->
    <div class="box">
        <p class="p2">{{ $component->title }}</p>
        <p class="p1">{{ @$component->content }}</p>
        @php $video = $component->extras->where('type', 'video')->first(); @endphp
        @if($video)
            <video width="800" src="{{ $video->content }}" controls></video>
        @endif
        <!---->
        <div id="box">
            <div class="heading">More {{ $component->contentable->title }}</div>
            <div class="trapezoid"></div>
            <!-- cards-->
            <div class="row load">
                @foreach($component->contentable->contents as $content)
                    @if($content->id != $component->id)
                        <div class="col l4 s12 m7">
                            <div class="card">
                                <div class="card-image">
                                    <img src="{{ @$content->extras->where('type', 'img')->first()->content }}">
                                </div>
                                <div class="card-content">
                                    <p>{{ $content->title }}</p>
                                </div>
                                <a class="read_more_btn" href="/s/{{ $site->address }}/item/{{ $content->id }}">
                                    <div class="card-action">Read more</div>
                                </a>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            <!-- end cards-->
        </div>
        <!-- end box div-->

        <!-- comments section -->
        <div class="heading">Comments</div>
        <div class="trapezoid"></div>
        <div class="actionBox">
            <ul>
                @foreach($component->extras->where('type', 'comment') as $comment)
                    <li>
                        <div>
                            <p class="commenter">{{ $comment->title }}</p>
                            <p>{{ $comment->content }}</p>
                            <span class="date ">{{ $comment->created_at->diffForHumans() }}</span>
                            <br>
                        </div>
                    </li>
                    <hr class="comment_separator">
                @endforeach
            </ul>
        </div>

        <!-- leave yr comment-->
        <div class="heading">Leave Your Comment</div>
        <div class="trapezoid"></div>
        <div class="row">
            <form class="col s12" method="POST" action="/sections/{{ $page->id }}/{{ $component->id }}">
                {{ csrf_field() }}
                <div class="row">
                    <div class="input-field col s6">
                        <label for="first_name">First Name</label>
                        <input name="first_name" type="text" class="validate" required>
                    </div>
                    <div class="input-field col s6">
                        <label for="last_name">Last Name</label>
                        <input name="last_name" type="text" class="validate" required>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <input name="email" type="email" class="validate" required>
                        <label for="email">Email</label>
                    </div>
                </div>
                <div class="row">
                    <form class="col s12">
                        <div class="row">
                            <div class="input-field col s12">
                                <label for="textarea1">Your message</label>
                                <textarea name="message" class="materialize-textarea" required></textarea>
                            </div>

                            <button type="submit" class="waves-effect waves-light btn">Submit</button>
                        </div>
                    </form>
                </div>

            </form>
        </div>

    </div>
    <!-- end white box-->
</div>
@stop