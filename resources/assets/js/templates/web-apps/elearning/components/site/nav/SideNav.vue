<template>
    <aside class="menu m-t-30 m-l-10">
		<ul class="menu-list">
            <li v-for="(page, i) in pages" :key="i">
                <a :href="`/s/${address}/${page.slug}`" :class="`${page.slug === slug? 'is-active': ''}`">
                    <span class="icon"><i :class="`fa fa-fw m-r-10 fa-${page.icon}`"></i></span>{{ page.title }}
                </a>
            </li>
		</ul>
        <ul class="menu-list" v-if="auth">
            <p class="menu-label is-capitalized">{{ auth.name }}</p>
            <li>
                <a :href="`/s/${address}/profile`" :class="`${'profile' === slug? 'is-active': ''}`">
                    <span class="icon"><i class="fa fa-fw m-r-10 fa-dashboard"></i></span> Profile
                </a>
            </li>
            <li>
                <a href="#" @click.stop="logout">
                    <span class="icon"><i class="fa fa-fw m-r-10 fa-sign-out"></i></span> Logout
                </a>
            </li>
        </ul>
	</aside>
</template>

<script>
    export default {
        name: 'SideNav',
        props: ['address', 'slug'],
        data() {
            return {

            };
        },
        computed: {
            auth() {
                return this.$store.getters.session(this.address);
            },
            pages() {
                let pages = [
                    { icon: 'newspaper-o', title: 'Articles', slug: 'articles'},
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
        mounted() {},
        methods: {
            logout() {
                this.$store.commit('removeSession', this.address);
				window.location = '/s/' + this.address;
            }
        }
    }
</script>

<style lang="css" scoped></style>
