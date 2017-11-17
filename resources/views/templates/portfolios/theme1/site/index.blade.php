@extends($site->theme->location . '.site.layout')

@section('content')
	<div class="row">
    	<!--Side-left section-->
      	<div class="col  l3 hide-on-small hide-on-med-and-down">
      		<!-- ========== ========== fixed - left side body start ========== ========== -->
			<div class="fixed-left-side-body">
				<div class="profile">
					<div class="profile-image center-align">
						<img src="/img/portfolios/portofolio/p.jpg" alt="Image">
					</div>
					<!-- /.profile-image -->
					<div class="profile-name center-align">
						<h1 class="user-name">Aaron Shay</h1>
						<p class="name_p">
							<span class="photoshop-color">UI/UX Designer</span> in Dewas
						</p>
					</div>
					<!-- /.profile-name -->
					<ul class="social-btn">
						<li><a href="#" ><i class="fa fa-facebook fa-3x " aria-hidden="true"></i></a></li>
						<li><a href="#"><i class="fa fa-twitter fa-3x" aria-hidden="true"></i></a></li>
						<li><a href="#"><i class="fa fa-linkedin fa-3x" aria-hidden="true"></i></a></li>
					</ul>
				</div>
				<!-- /.profile -->
			</div>
			<!-- /.fixed-left-side-body -->
      	</div><!--End Side-left section-->

	    <!--Side-right section-->
	    <div class="col s12  l9">     	  
			<!-- Navbars goes here -->
     		<nav>
				<div class="nav-wrapper">
		      		<a href="#" data-activates="slide-out" class="button-collapse"> <i class="material-icons">dehaze</i></a>
			      	<ul class="right hide-on-med-and-down section">
				        <li><a href="#home" class="hvr-shutter-out-horizontal waves-effect white-text">Home</a></li>
				        <li><a href="#about" class="hvr-shutter-out-horizontal waves-effect white-text ">About</a></li>
				        <li><a href="#skill" class="hvr-shutter-out-horizontal waves-effect white-text ">Skill</a></li>
				        <li><a href="#education" class="hvr-shutter-out-horizontal waves-effect white-text ">Education</a></li>
				        <li><a href="#experience" class="hvr-shutter-out-horizontal waves-effect white-text ">Experience</a></li>
				        <li><a href="#contact" class="hvr-shutter-out-horizontal waves-effect white-text ">Contact</a></li>
		      		</ul>
			    </div><!--end nav-wrapper-->
		  	</nav><!--End Navbars -->
	  		<!-- Side nav-->		      	
		  	<ul id="slide-out" class="side-nav">
				<li><a class="waves-effect" href="#home">Home</a></li>  
		        <li><a class="waves-effect" href="#about">About</a></li>
		        <li><a class="waves-effect" href="#education">Education</a></li>
		        <li><a class="waves-effect" href="#experience">Experience</a></li>
		        <li><a class="waves-effect" href="#contact">Contact</a></li>
			</ul>
	      	<!-- end Side nav-->
		  	<!--Section 1-->
		  	<div class="row sec section scrollspy" id="home">
		  		<div class="col l6 m6 s12 sec1_p_div">
		  			<h3>Hello,</h3>
		  			<p class="p1">My name is Aaron  </br>
		  			&amp; i'm graphical design</p>
		  		</div>
		  		<div class="col l6 m6  hide-on-small-only"><img src="/img/portfolios/portofolio/p.jpg" class="profile_pic2" ></div>
		  	</div>
		  	<!--End Section 1-->
		  	<!--Section 2-->
		  	<div class="row sec sec2 section scrollspy" id="about">
  				<h3><i class="fa fa-user-circle" aria-hidden="true"></i>  About Me</h3>
	  			<p  class="p2">
	  				Hello,I’m snow Creative Graphic Designer &amp; User Experience Desiger based in Website, I create digital Products a more Beautiful and usable place. This is Photoshop's version of Lorem Ipsum. Proin gravida nibh vel velit quet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulpuate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt
	  			</p>
  				<div class="row personal_details">
	  				<h5><i>PERSONAL DETAILS</i></h5>
					<table class="responsive-table">
						<tbody class="per_sec2">
							<tr >
								<td class="td-w25">Full Name</td>
								
								<td class="td-w65">Aaron Shay</td>
							</tr>
							<tr>
								<td class="td-w25">Father's Name</td>
								
								<td class="td-w65">Mr. Thomsen</td>
							</tr>
							<tr>
								<td class="td-w25">Address</td>
								
								<td class="td-w65">123 6th St. Melbourne, FL 32904. INDIA</td>
							</tr>
							<tr>
								<td class="td-w25">Zip Code</td>
								
								<td class="td-w65">12345</td>
							</tr>
							<tr>
								<td class="td-w25">Phone</td>
								
								<td class="td-w65">+0 123456789  ,  +0 123456789</td>
							</tr>
							<tr>
								<td class="td-w25">Email</td>
								
								<td class="td-w65">support@example.com</td>
							</tr>
							<tr>
								<td class="td-w25">Website</td>
								
								<td class="td-w65">http://example.com</td>
							</tr>
						</tbody>
					</table>
  				</div>
				<div class="row xx">
	  				<p class="quotes">
	  					If you hire people just because they can do a job, they'll work for your money. But if you hire people who believe what you believe, they'll work for you with blood, sweat, and tears.
	  				</p>
  					<a class="btn-large hireME hvr-buzz-out"><i class="fa fa-envelope-open" aria-hidden="true"></i> Hire Me</a>
  				</div>	
  			</div>
  			<!--End Section 2-->
  			<!-- section 3 -->
		  	<div class="row sec sec3 section scrollspy" id="skill">
		  		<h5>PROFESSIONAL SKILLS</h5>
		  		<br><br>	
		  			<div class="col l6 s12">
			  			<label class="l">Photoshop</label>
			  			<div class="progress"  style="width: 70%"></div>
		  			</div>
		  			<div class="col l6 s12">
		  				<label  class="l">HTML5</label>
		  				<div class="progress" style="width: 90%"></div>
		  			</div>
		  			<div class="col l6 s12">
		  				<label  class="l">Jquery</label>
		  				<div class="progress" style="width: 40%"></div>
		  			</div>
		  			<div class="col l6 s12">
		  				<label  class="l">Css3</label>
		  				<div class="progress" style="width: 50%"></div>
		  			</div>
		  			<div class="col l6 s12">
		  				<label  class="l">PHP</label>
		  				<div class="progress" style="width: 30%"></div>
		  			</div>
		  			<div class="col l6 s12">
		  				<label  class="l">Marketing</label>
		  				<div class="progress" style="width: 90%"></div>
		  			</div>
				</div>
		  		<!-- End section 3 -->
  				<!-- section 4 -->
  				<div class="row sec sec4 section scrollspy" id="education">
			  		<h3 class="white-text"><i class="fa fa-graduation-cap" aria-hidden="true"></i> Education </h3>
  					<ul class="collapsible" data-collapsible="accordion">
				    <li>
				      	<div class="collapsible-header"><i class="fa fa-pencil" aria-hidden="true"></i>master degree of design</div>
				      	<div class="collapsible-body z"><span>Successfully passed MBA’ on year 2015 - 2016 scoring CGPA 4.00 out of 4.00. The study fields were Cpmputer Architecture, Calculus, Physics Fundamental of Physics, Chemistry, Integral Mathematics. ABC University of los Angeles.</span></div>
				    </li>
				    <li>
				     	<div class="collapsible-header"><i class="fa fa-pencil" aria-hidden="true"></i>DIPLOMA IN COMPUTER</div>
				      	<div class="collapsible-body z"><span>Successfully passed MBA’ on year 2015 - 2016 scoring CGPA 4.00 out of 4.00. The study fields were Cpmputer Architecture, Calculus, Physics Fundamental of Physics, Chemistry, Integral Mathematics. ABC University of los Angeles.</span></div>
				    </li>
				    <li>
				      	<div class="collapsible-header"><i class="fa fa-pencil" aria-hidden="true"></i>BACHELOR DEGREE OF C.A</div>
				     	<div class="collapsible-body z"><span>Successfully passed MBA’ on year 2015 - 2016 scoring CGPA 4.00 out of 4.00. The study fields were Cpmputer Architecture, Calculus, Physics Fundamental of Physics, Chemistry, Integral Mathematics. ABC University of los Angeles.</span></div>
				    </li>
  				</ul>
  			</div>
  			<!-- End section 4 -->
  			<!-- section 5 -->
		  	<div class="row sec sec4 section scrollspy" id="experience">
		  		<h2><i class="fa fa-pencil" aria-hidden="true"></i> Work Experience</h2>
			  	<i class="material-icons w_e_1">bubble_chart</i>
			  	<p class="work_e_p">WEB DESIGNER AT MICROSOFT INC.<span class="w_e_s"> [Jun 2016 - Current]</span></p><br>
				<i class="material-icons w_e_2">bubble_chart</i><p class="work_e_p">WEB DESIGNER AT MICROSOFT INC. <span class="w_e_s"> [Jun 2015 - july 2016]</span></p><br>
				<i class="material-icons w_e_3">bubble_chart</i><p class="work_e_p">WEB DESIGNER AT MICROSOFT INC. <span class="w_e_s"> [April 2014 - March 2015]</span></p><br>
		  	</div>
		  	<!-- End section 5 -->

  	<!-- section 6-->
  	<div class="row sec sec4 section scrollspy" id="contact" >
  		<h3 class="white-text"><i class="fa fa-envelope-o" aria-hidden="true"></i> Contact me</h3>
		<form class="col l11 s11 c">
	      	<div class="row">
		        <div class="input-field col s6">
		          	<input  id="first_name" type="text" class="validate">
		          	<label for="first_name">First Name</label>
		        </div>
		        <div class="input-field col s6">
		          	<input id="last_name" type="text" class="validate">
		          	<label for="last_name">Last Name</label>
		        </div>
	      </div>
      
      <div class="row">
      <div class="input-field col s12">
        <div class="input-field col s12">
          <input id="email" type="email" class="validate">
          <label for="email">Email</label>
        </div>
      </div>
      
      <div class="input-field col s12">
          <textarea id="textarea1" class="materialize-textarea"></textarea>
          <label for="textarea1">Your Message</label>
        </div>
        </div>

		<a class="waves-effect waves-light btn-large  hvr-underline-from-center">Submit</a>
    </form> 
  	</div>
  	<!-- end section 6-->

    </div><!--end row-->  
@stop
