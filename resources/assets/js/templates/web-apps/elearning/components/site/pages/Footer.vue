<template>
    <footer class="footer">
        <div class="container">
            <div class="columns">
                <div class="column is-three-quarters has-text-centered">
                    <article class="media">
                        <figure class="media-left" v-if="logo">
                            <p class="image is-128x128">
                                <img :src="logo">
                            </p>
                        </figure>
                        <div class="media-content" v-if="site">
                            <h1 class="title is-capitalized">{{ site.name }}</h1>
                            <p class="content">{{ paragraph }}</p>
                        </div>
                    </article>
                </div>
                <div class="column" v-if="links">
                    <aside class="menu">
                        <p class="menu-label">Links </p>
                        <ul class="menu-list">
                            <li v-for="link in links">
                                <a :href="link.content" target="_blank">
                                    <span class="icon">
                                        <i :class="`fa fa-${link.type}`"></i>
                                    </span>
                                    <span class="is-capitalized">{{ link.type }}</span>
                                </a>
                            </li>
                        </ul>
                    </aside>
                </div>
            </div>
        </div>
    </footer>
</template>

<script>
export default {
    name: 'Footer',
    props: ['address', 'id'],
    data () {
        return {
            site: null,
            logo: null,
            paragraph: null,
            links: null
        }
    },
    mounted() {
        this.getData();
    },
    methods: {
        getData() {
            window.axios.get('/api/constants/' + this.id)
            .then(res => {
                this.site = res.data.site;
                let logo = _.findWhere(res.data.site.extras, {type: 'logo'});
                this.logo = logo ? logo.content : null;
                 let paragraph = _.findWhere(res.data.contents, {type: 'paragraph'});
                this.paragraph = paragraph ? paragraph.content : null;
                this.links = _.findWhere(res.data.contents, {type: 'links', active: 1}).extras;
            })
            .catch(err => console.log(err))
        }
    }
}
</script>

<style lang="css" scoped>
</style>