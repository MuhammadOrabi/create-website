@php
    $section = $page->sections->where('title', 'Skill')->first();
@endphp

@if($section->contents->isNotEmpty()  && $section->active)
    <!-- section 3 -->
    <div class="row sec sec3 section scrollspy" id="skill">
        <h5>PROFESSIONAL SKILLS</h5>
        <br><br>    
        @foreach($section->contents as $skill)
            <div class="col l6 s12">
                <label class="l">{{ $skill->type }}</label>
                <div class="progress">
                    <div class="determinate" style="width: {{ $skill->content  }}%"></div>
                </div>
            </div>
        @endforeach
    </div>
    <!-- End section 3 -->
@endif