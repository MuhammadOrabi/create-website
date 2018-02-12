@php
    $section = $page->sections->where('title', 'About')->first();
    $about = $section->contents->where('type', 'about')->first();
    $name = $section->contents->where('type', 'name')->first();
    $father = $section->contents->where('type', 'father')->first();
    $address = $section->contents->where('type', 'address')->first();
    $zip = $section->contents->where('type', 'zip')->first();
    $number1 = $section->contents->where('type', 'number1')->first();
    $number2 = $section->contents->where('type', 'number2')->first();
    $email = $section->contents->where('type', 'email')->first();
    $website = $section->contents->where('type', 'website')->first();
    $hireme = $section->contents->where('type', 'hireme')->first();
@endphp
@if($section->contents->isNotEmpty() && $section->active)
    <div class="row sec sec2 section scrollspy" id="about">
        @if($about && $about->content)
            <h3><i class="fa fa-user-circle" aria-hidden="true"></i>  About Me</h3>
            <p  class="p2">{{ $about->content }}</p>
        @endif
        <div class="row personal_details">
            <h5><i>PERSONAL DETAILS</i></h5>
            <table class="responsive-table">
                <tbody class="per_sec2">
                    @if($name && $name->content)
                        <tr>
                            <td class="td-w25">Full Name</td>
                            <td class="td-w65">{{ $name->content }}</td>
                        </tr>
                    @endif
                    @if($father && $father->content)
                        <tr>
                            <td class="td-w25">Father's Name</td>
                            <td class="td-w65">{{ $father->content }}</td>
                        </tr>
                    @endif
                    @if($address && $address->content)
                        <tr>
                            <td class="td-w25">Address</td>
                            <td class="td-w65">{{ $address->content }}</td>
                        </tr>
                    @endif
                    @if($zip && $zip->content)
                        <tr>
                            <td class="td-w25">Zip Code</td>
                            <td class="td-w65">{{ $zip->content }}</td>
                        </tr>
                    @endif
                    @if($number1 && $number1->content)
                        <tr>
                            <td class="td-w25">Phone</td>
                            <td class="td-w65">{{ $number1->content }}</td>
                        </tr>
                    @endif
                    @if($number2 && $number2->content)
                        <tr>
                            <td class="td-w25">Another Phone</td>
                            <td class="td-w65">{{ $number2->content }}</td>
                        </tr>
                    @endif
                    @if($email && $email->content)
                        <tr>
                            <td class="td-w25">Email</td>
                            <td class="td-w65">{{ $email->content }}</td>
                        </tr>
                    @endif
                    @if($website && $website->content)
                        <tr>
                            <td class="td-w25">Website</td> 
                            <td class="td-w65">{{ $website->content }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        @if($hireme && $hireme->content)
            <div class="row xx">
                <p class="quotes">{{ $hireme->content }}</p>
                <a class="btn-large hireME hvr-buzz-out" href="#contact"><i class="fa fa-envelope-open" aria-hidden="true"></i> Hire Me</a>
            </div>  
        @endif
    </div>
@endif
<!--End Section 2-->