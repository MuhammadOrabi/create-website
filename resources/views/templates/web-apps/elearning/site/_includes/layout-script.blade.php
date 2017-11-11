@php
	$authSlugs = ['profile', 'lessons', 'lesson', 'forum', 'course', ''];
	$notAuthSlugs = ['signin', 'signup', 'course', ''];
	$notAuthPages = $site->pages->whereNotIn('slug', $authSlugs)->all();
	$authPages = $site->pages->whereNotIn('slug', $notAuthSlugs)->all();	
@endphp
<script type="text/javascript">
	const app = new Vue({
		el: '#app',
		store: Vue.store,
		data: {
			drawer: false,
		    drawerRight: false,
		    right: false,
		    left: false,
		    siteNameVisibility: 'title',
		    nav: {text: '{{ $site->name }}', link: '/s/{{ $site->address }}' },
		    rightMainNavCheck: false,
		    rightMainNav: [],
		    leftMainNavCheck: false,
		    leftMainNav: [],
		    rightSubNavCheck: true,
		    rightSubNav: [],
		    leftSubNavCheck: false,
		    leftSubNav: [],
		    toolBarMenu: [
		    	@foreach($notAuthPages as $page)
            		{
            			text: '{{ $page->title }}', link: '/s/{{ $site->address }}/{{ $page->slug }}'
            		},
            	@endforeach
		    ],
		    authMenu: false,
		    authUserName: '',
		    authMenuList: []
		},
		beforeMount() {
			this.rightSubNav = this.toolBarMenu;
		},
		computed: {
			auth() {
  				return this.$store.getters.session('{{ $site->address }}');
  			}
		},
		methods: {
			clickMenu(option) {
				if (option == 'logout') {
					
				}
			}
		}
	});
</script>