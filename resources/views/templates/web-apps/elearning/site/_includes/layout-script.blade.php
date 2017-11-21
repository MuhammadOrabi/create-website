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
		    authUserName: '',
		    authMenuList: []
		},
		beforeMount() {
			this.rightSubNav = this.toolBarMenu;
			let auth = this.auth;
			if (auth) {
				axios.get('/api/user', { headers: { 'Authorization': 'Bearer ' + auth.token } })
				.then(res => {
					this.authUserName = res.data.user.name;
				})
				.catch(err => console.log(err));

				this.redirectIfAuthenticated();
			} else {
				this.redirectIfNotAuthenticated();
			}
		},
		computed: {
			auth() {
  				return this.$store.getters.session('{{ $site->address }}');
  			},
  			toolBarMenu() {
	  			let menu = [
	  				{ icon: 'poll', text: 'News', link: '/s/{{ $site->address }}/news' },
	  				{ icon: 'question_answer', text: 'About', link: '/s/{{ $site->address }}/about' },
	  				{ icon: 'email', text: 'Contact', link: '/s/{{ $site->address }}/contact' },
	  				{ icon: 'list', text: 'Courses', link: '/s/{{ $site->address }}/courses' }
				];
				if (this.auth) {
					this.authMenuList.push({ icon: 'person', text: 'Profile', link: '/s/{{ $site->address }}/profile' });
					this.authMenuList.push({ icon: 'local_activity', text: 'Activites', link: '/s/{{ $site->address }}/activites' });
					this.authMenuList.push({ icon: 'settings', text: 'Settings', link: '/s/{{ $site->address }}/settings' });
					this.authMenuList.push({ divider: true });
					this.authMenuList.push({icon: 'exit_to_app', text: 'Logout', click: 'logout'});
				} else {
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
				let slugs = ['profile', 'lesson', 'settings', 'activites'];
				if (slugs.includes(slug)) {
					window.location = '/s/{{ $site->address }}/signin';
				}
			}
		}
	});
</script>
