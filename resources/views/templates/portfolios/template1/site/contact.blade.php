<!-- section 6-->
    <div class="row sec sec4 section scrollspy" id="contact" >
        <h3 class="white-text"><i class="fa fa-envelope-o" aria-hidden="true"></i> Contact me</h3>
        <form class="col l11 s11 c" action="/sections/{{ $page->id }}" method="POST">
            {{ csrf_field() }}
            <div class="row">
                <div class="input-field col s6">
                    <label for="name">Name</label>
                    <input  id="name" type="text" name="name" class="validate" required>
                </div>
                <div class="input-field col s6">
                    <label for="subject">Subject</label>
                    <input id="subject" type="text" name="subject" class="validate" required>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s12">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" class="validate" required>
                </div>
            </div>
      
            <div class="row">
                <div class="input-field col s12">
                    <label for="textarea1">Your Message</label>
                    <textarea id="textarea1" class="materialize-textarea validate" name="message" required></textarea>
                </div>
            </div>

            <button class="waves-effect waves-light btn-large  hvr-underline-from-center" type="submit">Submit</button>
        </form> 
    </div>
    <!-- end section 6-->