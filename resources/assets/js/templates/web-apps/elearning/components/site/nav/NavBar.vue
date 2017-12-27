<template>
    <div class="container">
		<div class="navbar-brand">
			<a :href="`/s/${address}`" class="navbar-item">
				<img :src="logo.content" alt="Logo" class="p-r-10" v-if="logo">
                <span class="is-capitalized" v-if="site">{{ site.name }}</span>
			</a>
			<button class="button navbar-burger" id="right-slideout-button">
				<span></span>
				<span></span>
				<span></span>
			</button>
		</div>
		<div class="navbar-menu">
			<div class="navbar-start"></div>
			<div class="navbar-end nav-menu " style="overflow: visible">
                <a v-for="(page, i) in pages" :key="i" :href="`/s/${address}/${page.slug}`" 
                    :class="`navbar-item is-tab ${page.slug === slug? 'is-active': ''}`">
                    <span class="icon"><i :class="`fa fa-fw m-r-10 fa-${page.icon}`"></i></span>{{ page.title }}
                </a>
                <div v-if="auth" class="navbar-item has-dropdown is-hoverable">
                    <a href="#" class="navbar-link is-capitalized">{{ auth.name }}</a>
                    <div class="navbar-dropdown is-right">
                        <a class="navbar-item" :href="`/s/${address}/profile`">
                            <span class="icon"><i class="fa fa-fw m-r-10 fa-dashboard"></i></span> Profile
                        </a>
                        <a class="navbar-item" @click="logout">
                            <span class="icon"><i class="fa fa-fw m-r-10 fa-sign-out"></i></span> Logout
                        </a>
                    </div>
                </div>
			</div>
		</div>
	</div>
</template>

<script>
    const _ = window._;
    export default {
        name: 'NavBar',
        props: ['address', 'slug'],
        data() {
            return {
                user: null,
                site: null,
                logo: null
            };
        },
        computed: {
            auth() {
                return this.$store.getters.session(this.address);
            },
            pages() {
                let pages = [
                    { icon: 'newspaper-o', title: 'News', slug: 'news'},
                    { icon: 'info-circle', title: 'About', slug: 'about'},
                    { icon: 'at', title: 'Contact', slug: 'contact'},
                    { icon: 'list', title: 'Courses', slug: 'courses'}
                ];
                if (!this.auth) {
                    pages.push({ icon: 'sign-in', title: 'Login', slug: 'login'});
                    pages.push({ icon: 'user-plus', title: 'Register', slug: 'register'});
                }
                return pages;
            }
        },
        mounted() {
            this.getData();
        },
        methods: {
            getData() {
                window.axios.get('/api/site/info/nav/' + this.address)
                .then(res => {
                    this.logo = _.findWhere(res.data.extras, {type: 'logo'});
                    this.site = res.data;
                })
                .catch(err => console.log(err));
            },
            logout() {
                this.$store.commit('removeSession', this.address);
				window.location = '/s/' + this.address;
            }
        }
    }
</script>

<style lang="css" scoped></style>
