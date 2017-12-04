<script type="text/javascript">
	
	const app = new Vue({
		el: '#app',
		store: Vue.store,
		data: {
			drawer: null,
		    drawerRight: null,
		    right: null,
		    left: null,
		    siteNameVisibility: 'title',
		    nav: {text: '{{ $site->name }}', link: '/s/{{ $site->address }}' },
		    rightMainNavCheck: null,
		    rightMainNav: [],
		    leftMainNavCheck: null,
		    leftMainNav: [],
		    rightSubNavCheck: true,
		    rightSubNav: [],
		    leftSubNavCheck: null,
		    leftSubNav: [],
		    authMenuList: []
		},
		beforeMount() {
			this.rightSubNav = this.toolBarMenu;
			let auth = this.auth;
			if (auth) {
				this.authMenuList.push({ icon: 'person', text: 'Profile', link: '/s/{{ $site->address }}/profile' });
				this.authMenuList.push({ divider: true });
				this.authMenuList.push({icon: 'exit_to_app', text: 'Logout', click: 'logout'});

				this.rightSubNav.push({
					icon: 'keyboard_arrow_up',
					'icon-alt': 'keyboard_arrow_down',
					text: this.authUserName,
					model: false,
					children: [
						{icon: 'exit_to_app', text: 'Logout', click: 'logout'}
					]
				});

				this.redirectIfAuthenticated();
			} else {
				this.redirectIfNotAuthenticated();
			}
		},
		computed: {
			auth() {
  				return this.$store.getters.session('{{ $site->address }}');
  			},
			authUserName() {
				return this.auth.name;
			},
  			toolBarMenu() {
	  			let menu = [
	  				{ icon: 'poll', text: 'News', link: '/s/{{ $site->address }}/news' },
	  				{ icon: 'question_answer', text: 'About', link: '/s/{{ $site->address }}/about' },
	  				{ icon: 'email', text: 'Contact', link: '/s/{{ $site->address }}/contact' },
	  				{ icon: 'list', text: 'Courses', link: '/s/{{ $site->address }}/courses' }
				];
				if (!this.auth) {
					menu.push({ icon: 'face', text: 'Sign up', link: '/s/{{ $site->address }}/signup'});
					menu.push({ icon: 'lock_open', text: 'Sign in', link: '/s/{{ $site->address }}/signin' });
				}
				return menu;
  			},
  			authMenu() {
  				return this.auth ? true : false;
  			}
		},
		methods: {
			clickMenu(option) {
				if (option == 'logout') {
					this.$store.commit('removeSession', '{{ $site->address }}');
					window.location = '/s/{{ $site->address }}';
				}
			},
			redirectIfAuthenticated() {
				let slug = '{{ $page->slug }}';
				if (slug === 'signin' || slug === 'signup') {
					window.location = '/s/{{ $site->address }}';
				}
			},
			redirectIfNotAuthenticated() {
				let slug = '{{ $page->slug }}';
				let slugs = ['profile', 'lesson'];
				if (slugs.includes(slug)) {
					window.location = '/s/{{ $site->address }}/signin';
				}
			}
		}
	});
</script>
