<template>
    <section>
        <section class="hero is-medium is-dark is-bold">
            <div class="hero-body">
                <div class="container">
                     <article class="media">
                        <figure class="media-left" v-if="img">
                            <p class="image is-128x128">
                                <img :src="img">
                            </p>
                        </figure>
                        <div class="media-content" v-if="user">
                            <h1 class="title is-capitalized">{{ site.name }}</h1>
                            <!-- <h1 class="subtitle is-capitalized">{{ user.name }}</h1> -->
                            <p class="content">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                            </p>
                        </div>
                    </article>
                </div>
            </div>
        </section>
    </section>
</template>

<script>
export default {
    name: 'About',
    props: ['address'],
    data () {
        return {
            site: null,
            user: null,
            img: null,
        }
    },
    mounted() {
        this.getData();
    },
    methods: {
        getData() {
            window.axios.get('/api/sites/info/site-info/' + this.address)
            .then(res => {
                this.site = res.data;
                this.user = this.site.user;
            })
            .catch(err => console.log(err))
        }
    }
}
</script>

<style lang="css" scoped>
</style>