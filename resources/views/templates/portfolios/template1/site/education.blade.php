@php
    $section = $page->sections->where('title', 'Education')->first();
@endphp

@if($section->contents->isNotEmpty())
    <!-- section 4 -->
    <div class="row sec sec4 section scrollspy" id="education">
        <h3 class="white-text"><i class="fa fa-graduation-cap" aria-hidden="true"></i> Education </h3>
        <ul class="collapsible" data-collapsible="accordion">
            @foreach($section->contents as $content)
                <li>
                    <div class="collapsible-header">
                        <i class="fa fa-pencil" aria-hidden="true"></i>{{ $content->content }}
                    </div>
                    <div class="collapsible-body z">
                        <table class="responsive-table">
                            <tbody class="per_sec2">
                                <tr>
                                    <td class="td-w25">School</td>
                                    <td class="td-w65">{{ $content->title }}</td>
                                </tr>
                                @foreach($content->extras as $extra)
                                    @if($extra->type == 'from_year' || $extra->type == 'to_year')
                                        <tr>
                                            <td class="td-w25">{{ studly_case($extra->type) }}</td>
                                            <td class="td-w65">
                                                {{ Carbon\Carbon::parse($extra->content)->diffForHumans() }}
                                            </td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td class="td-w25">{{ studly_case($extra->type) }}</td>
                                            <td class="td-w65">{{ $extra->content }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    <!-- End section 4 -->
@endif