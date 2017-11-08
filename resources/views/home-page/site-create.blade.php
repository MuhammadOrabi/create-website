@extends('layouts.vuetify')
@section('title')
	Create Website
@stop
@section('content')
	<v-layout justify-center>
		<site-creator token="{{ auth()->user()->getToken('') }}" ></site-creator>
	</v-layout>
@stop
@section('scripts')
	<script type="text/javascript">
		new Vue({
				el: '#app',
				data: {
					drawer: false,
				    drawerRight: false,
				    right: false,
				    left: false,
				    nav: {text: 'Create Website', link: '/', logo: '/img/logo.png'},
				    rightMainNavCheck: false,
				    rightMainNav: [],
				    leftMainNavCheck: false,
				    leftMainNav: [],
				    rightSubNavCheck: false,
				    rightSubNav: [],
				    leftSubNavCheck: true,
				    leftSubNav: [{icon: 'dashboard', link: '/home', text: 'Home'}],
				    authUser: true
				}
			});
	</script>
@stop

