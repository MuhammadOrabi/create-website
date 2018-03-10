@extends($site->theme->location . '.site.layout') 
@section('title') 
    {{ $site->name }}
@stop 
@section('content')
<div class="col l9 s12">

    <!--slider-->
    <div class="slider">
        <ul class="slides">
            <li>
                <a href="">
                    <img src="imgs/Coco-Movie-Mexican-Box-Office-Record-Pixar.jpg">
                    <div class="caption center-align">
                        <h3>Pixar's Coco Beats Avengers as Mexico's Biggest Movie Ever</h3>
                    </div>
                </a>
            </li>
            <li>
                <a href="">
                    <img src="imgs/maxresdefault.jpg">
                    <div class="caption left-align">
                        <h3>Trailer For 'Deadpool 2' Has Dropped And It's Absolutely Bizarre</h3>
                    </div>
                </a>
            </li>
            <li>
                <a href="">
                    <img src="imgs/Justice League.jpg">
                    <div class="caption right-align">
                        <h3>'Thor: Ragnarok' Set To Beat 'Justice League' In The Film's Debut Weekend In North America</h3>
                    </div>
                </a>
            </li>
            <li>
                <a href="">
                    <img src="imgs/Strangers2.jpg">
                    <div class="caption center-align">
                        <h3>Strangers: Prey at Night</h3>
                    </div>
                </a>
            </li>
        </ul>
    </div>
    <!--end slider -->

    <!--LATEST MOVIE NEWS HEADLINES-->
    <div id="box">
        <div class="heading">LATEST MOVIE NEWS HEADLINES</div>
        <div class="trapezoid"></div>
        <!-- cards-->
        <div class="row load">
            <div class="col l4 s12 m7">
                <div class="card">
                    <div class="card-image">
                        <img src="imgs/Strangers2.jpg">

                    </div>
                    <div class="card-content">
                        <p>I am a very simple card. I am good at containing small bits of information. I am convenient because
                            I require little markup to use effectively.</p>
                    </div>
                    <a class="read_more_btn" href="read_more.html">
                        <div class="card-action">
                            Read more
                        </div>
                    </a>
                </div>
            </div>
            <!-- ^^^^ -->
            <div class="col l4 s12 m7">
                <div class="card">
                    <div class="card-image">
                        <img src="imgs/Strangers2.jpg">

                    </div>
                    <div class="card-content">
                        <p>I am a very simple card. I am good at containing small bits of information. I am convenient because
                            I require little markup to use effectively.</p>
                    </div>

                    <a class="read_more_btn" href="#">
                        <div class="card-action">
                            Read more
                        </div>
                    </a>

                </div>
            </div>
            <!-- ^^^^ -->
            <div class="col l4 s12 m7">
                <div class="card">
                    <div class="card-image">
                        <img src="imgs/Strangers2.jpg">

                    </div>
                    <div class="card-content">
                        <p>I am a very simple card. I am good at containing small bits of information. I am convenient because
                            I require little markup to use effectively.</p>
                    </div>
                    <a class="read_more_btn" href="#">
                        <div class="card-action">
                            Read more
                        </div>
                    </a>
                </div>
            </div>
            <!-- ^^^^ -->
        </div>
        <div class="row load">
            <div class="col l4 s12 m7">
                <div class="card">
                    <div class="card-image">
                        <img src="imgs/Strangers2.jpg">

                    </div>
                    <div class="card-content">
                        <p>I am a very simple card. I am good at containing small bits of information. I am convenient because
                            I require little markup to use effectively.</p>
                    </div>
                    <a class="read_more_btn" href="#">
                        <div class="card-action">
                            Read more
                        </div>
                    </a>
                </div>
            </div>
            <div class="col l4 s12 m7">
                <div class="card">
                    <div class="card-image">
                        <img src="imgs/Strangers2.jpg">

                    </div>
                    <div class="card-content">
                        <p>I am a very simple card. I am good at containing small bits of information. I am convenient because
                            I require little markup to use effectively.</p>
                    </div>
                    <a class="read_more_btn" href="#">
                        <div class="card-action">
                            Read more
                        </div>
                    </a>
                </div>
            </div>
            <div class="col l4 s12 m7">
                <div class="card">
                    <div class="card-image">
                        <img src="imgs/Strangers2.jpg">

                    </div>
                    <div class="card-content">
                        <p>I am a very simple card. I am good at containing small bits of information. I am convenient because
                            I require little markup to use effectively.</p>
                    </div>
                    <a class="read_more_btn" href="#">
                        <div class="card-action">
                            Read more
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <!-- ^^^^ -->
        <div class="row load">
            <div class="col l4 s12 m7">
                <div class="card">
                    <div class="card-image">
                        <img src="imgs/Strangers2.jpg">

                    </div>
                    <div class="card-content">
                        <p>I am a very simple card. I am good at containing small bits of information. I am convenient because
                            I require little markup to use effectively.</p>
                    </div>
                    <a class="read_more_btn" href="#">
                        <div class="card-action">
                            Read more
                        </div>
                    </a>
                </div>
            </div>
            <div class="col l4 s12 m7">
                <div class="card">
                    <div class="card-image">
                        <img src="imgs/Strangers2.jpg">

                    </div>
                    <div class="card-content">
                        <p>I am a very simple card. I am good at containing small bits of information. I am convenient because
                            I require little markup to use effectively.</p>
                    </div>
                    <a class="read_more_btn" href="#">
                        <div class="card-action">
                            Read more
                        </div>
                    </a>
                </div>
            </div>
            <div class="col l4 s12 m7">
                <div class="card">
                    <div class="card-image">
                        <img src="imgs/Strangers2.jpg">

                    </div>
                    <div class="card-content">
                        <p>I am a very simple card. I am good at containing small bits of information. I am convenient because
                            I require little markup to use effectively.</p>
                    </div>
                    <a class="read_more_btn" href="#">
                        <div class="card-action">
                            Read more
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <!-- ^^^^ -->
        <div class="row load">
            <div class="col l4 s12 m7">
                <div class="card">
                    <div class="card-image">
                        <img src="imgs/Strangers2.jpg">

                    </div>
                    <div class="card-content">
                        <p>I am a very simple card. I am good at containing small bits of information. I am convenient because
                            I require little markup to use effectively.</p>
                    </div>
                    <a class="read_more_btn" href="#">
                        <div class="card-action">
                            Read more
                        </div>
                    </a>
                </div>
            </div>
            <div class="col l4 s12 m7">
                <div class="card">
                    <div class="card-image">
                        <img src="imgs/Strangers2.jpg">

                    </div>
                    <div class="card-content">
                        <p>I am a very simple card. I am good at containing small bits of information. I am convenient because
                            I require little markup to use effectively.</p>
                    </div>
                    <a class="read_more_btn" href="#">
                        <div class="card-action">
                            Read more
                        </div>
                    </a>
                </div>
            </div>
            <div class="col l4 s12 m7">
                <div class="card">
                    <div class="card-image">
                        <img src="imgs/Strangers2.jpg">

                    </div>
                    <div class="card-content">
                        <p>I am a very simple card. I am good at containing small bits of information. I am convenient because
                            I require little markup to use effectively.</p>
                    </div>
                    <a class="read_more_btn" href="#">
                        <div class="card-action">
                            Read more
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <!-- ^^^^ -->
        <div class="row load">
            <div class="col l4 s12 m7">
                <div class="card">
                    <div class="card-image">
                        <img src="imgs/Strangers2.jpg">

                    </div>
                    <div class="card-content">
                        <p>I am a very simple card. I am good at containing small bits of information. I am convenient because
                            I require little markup to use effectively.</p>
                    </div>
                    <a class="read_more_btn" href="#">
                        <div class="card-action">
                            Read more
                        </div>
                    </a>
                </div>
            </div>
            <div class="col l4 s12 m7">
                <div class="card">
                    <div class="card-image">
                        <img src="imgs/Strangers2.jpg">

                    </div>
                    <div class="card-content">
                        <p>I am a very simple card. I am good at containing small bits of information. I am convenient because
                            I require little markup to use effectively.</p>
                    </div>
                    <a class="read_more_btn" href="#">
                        <div class="card-action">
                            Read more
                        </div>
                    </a>
                </div>
            </div>
            <div class="col l4 s12 m7">
                <div class="card">
                    <div class="card-image">
                        <img src="imgs/Strangers2.jpg">

                    </div>
                    <div class="card-content">
                        <p>I am a very simple card. I am good at containing small bits of information. I am convenient because
                            I require little markup to use effectively.</p>
                    </div>
                    <a class="read_more_btn" href="#">
                        <div class="card-action">
                            Read more
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <!-- ^^^^ -->
        <div class="row load">
            <div class="col l4 s12 m7">
                <div class="card">
                    <div class="card-image">
                        <img src="imgs/Strangers2.jpg">

                    </div>
                    <div class="card-content">
                        <p>I am a very simple card. I am good at containing small bits of information. I am convenient because
                            I require little markup to use effectively.</p>
                    </div>
                    <a class="read_more_btn" href="#">
                        <div class="card-action">
                            Read more
                        </div>
                    </a>
                </div>
            </div>
            <div class="col l4 s12 m7">
                <div class="card">
                    <div class="card-image">
                        <img src="imgs/Strangers2.jpg">

                    </div>
                    <div class="card-content">
                        <p>I am a very simple card. I am good at containing small bits of information. I am convenient because
                            I require little markup to use effectively.</p>
                    </div>
                    <a class="read_more_btn" href="#">
                        <div class="card-action">
                            Read more
                        </div>
                    </a>
                </div>
            </div>
            <div class="col l4 s12 m7">
                <div class="card">
                    <div class="card-image">
                        <img src="imgs/Strangers2.jpg">

                    </div>
                    <div class="card-content">
                        <p>I am a very simple card. I am good at containing small bits of information. I am convenient because
                            I require little markup to use effectively.</p>
                    </div>
                    <a class="read_more_btn" href="#">
                        <div class="card-action">
                            Read more
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <!-- ^^^^ -->
        <a class="lm_btn" href="#" id="loadMore">Load More</a>
        <p class="totop">
            <a href="#top">Back to top</a>
        </p>

        <!-- END cards-->


    </div>

    <!-- END LATEST MOVIE NEWS HEADLINES-->


</div>
@stop