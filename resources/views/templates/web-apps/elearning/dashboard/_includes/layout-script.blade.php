@php
	$slugs = array('' , 'about', 'news', 'contact', 'courses', 'signup');
	$sideNavPages = $site->pages->whereIn('slug', $slugs)->all();
@endphp

<script type="text/javascript">
	const app = new Vue({
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
		    leftMainNavCheck: true,
		    leftMainNav: [
		    	{ icon: 'open_in_new', text: 'Open Site', link: '/s/{{ $site->address }}', target: '_blank' },
		        { divider: true },
		        { icon: 'assessment', text: 'Stats', link: '#', active: false },
		        {
		          	icon: 'keyboard_arrow_up',
		          	'icon-alt': 'keyboard_arrow_down',
		          	text: 'Pages',
		          	model: false,
		          	children: [
		          		@foreach($sideNavPages as $page)
		            		{ 
		            			icon: 'keyboard_arrow_right', 
		            			text: '{{ $page->title }}', link: '/dashboard/pages/{{ $page->id }}/edit',
								active: true
		            		},
		            	@endforeach
		          	]
		        },
		        { icon: 'perm_media', text: 'Media', link: '/dashboard/media/{{ $site->address }}', active: true },
		        { divider: true },
		        { icon: 'settings', text: 'Settings', link: '/dashboard/settings/{{ $site->address }}', active: false },
		        { icon: 'help', text: 'Help', active: false },
		        { icon: 'chat_bubble', text: 'Send feedback', active: false },
		        { divider: true },
		        { icon: 'plus_one', text: 'Create New website', link: '/site/create', target: '_blank' }
		    ],
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
		    leftSubNavCheck: true,
		    leftSubNav: [],
		    toolBarMenu: [{icon: 'dashboard', link: '/home', text: 'Home'}],
		    authMenu: true,
		    authUserName: '{{ auth()->user()->name }}',
		    authMenuList: [{icon: 'exit_to_app', text: 'Logout', click: 'logout'}],
		},
		beforeMount() {
			this.leftSubNav = this.leftMainNav;
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