<script>
    new Vue({
        beforeMount() {
            let auth = this.$store.getters.session('{{ $site->address }}');
            let slug = '{{ $slug }}';
            if (auth) {
                if (slug === 'login' || slug === 'register') {
                    window.location = '/s/{{ $site->address }}';
				}
			} else {
                let slugs = ['profile', 'lesson'];
				if (slugs.includes(this.slug)) {
					window.location = '/s/{{ $site->address }}/login';
				}
			}
        }
    });
</script>