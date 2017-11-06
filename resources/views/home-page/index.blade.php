@extends('layouts.materialize')

@section('title')
	Create Website
@stop

@section('content')
	@include('home-page._includes.toolbar')
	<div id="index-banner" class="parallax-container">
	    <div class="section no-pad-bot">
	      	<div class="container">
	        	<br><br>
		        <h1 class="header center teal-text text-lighten-2">Create Website</h1>
		        <div class="row center">
		          <h5 class="header col s12 light">It All Starts with Your Stunning Website</h5>
		        </div>
		        <div class="row center">
		          	<a href="/login" id="download-button" class="btn-large waves-effect waves-light teal lighten-1">
		          		Get Started
		      		</a>
		        </div>
		        <br><br>
	      	</div>
	    </div>
	    <div class="parallax"><img src="/img/background1.jpg" alt="Unsplashed background img 1"></div>
  	</div>
  	<div class="container">
    	<div class="section">
	      	<!--   Icon Section   -->
	      	<div class="row">
		        <div class="col s12 m4">
		          	<div class="icon-block">
			            <h2 class="center brown-text"><i class="material-icons">help</i></h2>
			            <h5 class="center">Find help when you need it</h5>
			            <p class="light center">
			            	Get support from our experts through email or live chat. <br>
			            	Connect with a community of users through forums.
			            </p>
		          	</div>
		        </div>
        		<div class="col s12 m4">
          			<div class="icon-block">
			            <h2 class="center brown-text"><i class="material-icons">group</i></h2>
			            <h5 class="center">Build an audience</h5>
			            <p class="light center">
			            	Use our social media syndication, sharing buttons, and insightful site statistics to increase your traffic and monitor your growth.
			            </p>
          			</div>
        		</div>
		        <div class="col s12 m4">
		          	<div class="icon-block">
			            <h2 class="center brown-text"><i class="material-icons">lock</i></h2>
			            <h5 class="center">A secure website you can count on</h5>

			            <p class="light center">
			            	Your site will always be available, secure, and automatically backed up.
			        	</p>
		         	</div>
		        </div>
      		</div>
    	</div>
  	</div>
  	<div class="parallax-container valign-wrapper">
	    <div class="section no-pad-bot">
	      	<div class="container">
		        <div class="row center">
		          	<h5 class="header col s12 light">
		          		We’ve got you covered. Free websites designer-made templates, beautiful galleries, mobile optimized, domains, huge image collection, secure hosting. 
		          	</h5>
		        </div>
	      	</div>
	    </div>
	    <div class="parallax"><img src="/img/background2.jpg" alt="Unsplashed background img 2"></div>
  	</div>
  	<div class="container">
	    <div class="section">
	      	<div class="row">
		        <div class="col s12 center">
		          	<h3><i class="mdi-content-send brown-text"></i></h3>
		          	<h4>Use the Power of Artificial Design Intelligence</h4>
		          	<p class="left-align light">
		          		Our API learns about you and applies this knowledge to create the perfect website for your needs. From billions of combinations including layouts, images, text, contact forms and more, selects the most stunning just for you - creating a one-of-a-kind free website.
		          	</p>
		        </div>
	      	</div>
    	</div>
  	</div>
  	<div class="parallax-container valign-wrapper">
	    <div class="section no-pad-bot">
	      	<div class="container">
		        <div class="row center">
		          	<h5 class="header col s12 light">Everything You Need to Create Your Stunning Website</h5>
		        </div>
	      	</div>
	    </div>
	    <div class="parallax"><img src="/img/background3.jpg" alt="Unsplashed background img 3"></div>
  	</div>
  	<footer class="page-footer grey darken-3">
	    <div class="container">
	      	<div class="row">
		        <div class="col l6 s12">
		          		<img src="/img/logo.png" alt="logo" width="70px" height="70px" class="responsive-img">
						<h3 class="subheading">Create Website</h3>
					<a id="logo-container" href="/" class="brand-logo">
					</a>
		          	<p class="grey-text text-lighten-4">	
						We are a cloud-based development platform. We make it easy for everyone to create a beautiful, professional web presence.
						Promote your business, showcase your art, set up an online e-Learning platform or just test out new ideas.
		          	</p>
		        </div>
		        
        		<div class="col l3 offset-l3 s12">
		          	<h5 class="white-text">Contact Us</h5>
		          	<ul>
			            <li><i class="material-icons left">email</i><a class="white-text p-4" href="#!">support@createwebsite.io</a></li>
			            <br>
			            <li><i class="material-icons left">help</i><a class="white-text" href="#!">Support</a></li>
		          	</ul>
		        </div>
	      	</div>
	    </div>
	    <div class="footer-copyright"></div>
	</footer>
@stop
