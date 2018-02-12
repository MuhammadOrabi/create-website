@php
    $section = $page->sections->where('title', 'Experience')->first();
@endphp

@if($section->contents->isNotEmpty()  && $section->active)
    <!-- section 5 -->
    <div class="row sec sec4 section scrollspy" id="experience">
        <h2><i class="fa fa-pencil" aria-hidden="true"></i> Work Experience</h2>
        @foreach($section->contents as $content)
            @php
                $from = $content->extras->where('type', 'from_year')->first();
                $to = $content->extras->where('type', 'to_year')->first();
            @endphp
            <i class="material-icons w_e_2">bubble_chart</i>
            <p class="work_e_p">
                {{ $content->title }} AT {{ $content->content }}. 
                <span class="w_e_s">
                    [ {{ Carbon\Carbon::parse($from->content)->diffForHumans() }} 
                    -  {{ $to ? Carbon\Carbon::parse($to->content)->diffForHumans() : 'Current' }}]
                </span>
            </p>
            <br>
        @endforeach
    </div>
    <!-- End section 5 -->
@endif