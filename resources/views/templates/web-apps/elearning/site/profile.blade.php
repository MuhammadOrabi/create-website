@extends($site->theme->location.'.layouts.site')

@section('content')
    <section class="hero is-medium is-light is-bold">
        <div class="hero-body">
            <div class="container">
                <article class="media">
                    <figure class="media-left">
                        <p class="image is-128x128">
                            <img src="/img/logo.png">
                        </p>
                    </figure>
                    <div class="media-content">
                        <h1 class="title">Muhammad Orabi</h1>
                        <h1 class="subtitle">Title</h1>
                    </div>
                    <div class="media-right">
                        <button class="button is-primary">
                            <b-icon icon="border-color"></b-icon>
                            <span>Edit</span>
                        </button>
                    </div>
                </article>
            </div>
        </div>
    </section>
@stop