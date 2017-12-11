@extends('layouts.vuetify')
@section('title')
	Create Website
@stop
@section('content')
	<v-layout justify-center>
		<site-creator dusk="site-creator" token="{{ auth()->user()->getToken('') }}" ></site-creator>
	</v-layout>
@stop
@section('scripts')
	<script type="text/javascript" src="/js/vuetify/app.js"></script>	
	<script type="text/javascript">
		new Vue({
			el: '#app',
			data: {
				drawer: false,
			    drawerRight: false,
			    right: false,
			    left: false,
			    siteNameVisibility: 'title',
			    nav: {text: 'Create Website', link: '/', logo: '/img/logo.png'},
			    rightMainNavCheck: false,
			    rightMainNav: [],
			    leftMainNavCheck: false,
			    leftMainNav: [],
			    rightSubNavCheck: true,
			    rightSubNav: [
			    	{icon: 'dashboard', link: '/home', text: 'Home'}, 
			    	{
			          	icon: 'keyboard_arrow_up',
			          	'icon-alt': 'keyboard_arrow_down',
			          	text: '{{ auth()->user()->name }}',
			          	model: false,
			          	children: [
			          		{icon: 'exit_to_app', text: 'Logout', click: 'logout'}
			          	]
			        }
			    ],
			    leftSubNavCheck: false,
			    leftSubNav: [],
			    toolBarMenu: [{icon: 'dashboard', link: '/home', text: 'Home'}],
			    authMenu: true,
			    authUserName: '{{ auth()->user()->name }}',
			    authMenuList: [{icon: 'exit_to_app', text: 'Logout', click: 'logout'}]
			},
			methods: {
				clickMenu(option) {
					if (option == 'logout') {
						axios.post('/logout')
						.then(res => location.reload())
						.catch(err => console.log(err));
					}
				}
			}
		});
	</script>
@stop

