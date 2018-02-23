<template>
    <div class="container">
        <p class="title has-text-centered" v-if="article">
            <strong class="title">{{ article.title }}</strong>
            <br>
            <span class="tag is-light">{{ moment(article.created_at).calendar() }}</span>
            <br>
            <span class="tag is-dark m-l-5 m-t-20" v-for="tag in tags" :key="tag.id">{{ tag.content }}</span>
        </p>
        <figure class="image is-16by9" v-if="img">
            <img :src="img">
        </figure>
        <br>
        <div class="content m-t-50 m-b-100 p-l-15 p-r-15" v-if="paragraph" v-html="paragraph"></div>
    </div>
</template>

<script>
import moment from 'moment';

export default {
    name: 'Article',
    props: ['id', 'address'],
    data () {
        return {
            img: null,
            article: null,
            tags: [],
            paragraph: ''
        }
    },
    mounted() {
        this.getData();
    },
    methods: {
        moment,
        getData() {
            window.axios.get('/api/sections/' + this.id)
            .then(res => {
                let section = res.data;
                if (section.page.site.address !== this.address) {return;}
                let img = _.findWhere(section.contents, {type: 'img'});
                this.img = img ? img.content : null;
                this.paragraph = _.findWhere(section.contents, {type: 'paragraph'}).content;
                this.article = section;
                this.tags = _.where(section.extras, {type: 'tag'});
            })
            .catch(err => console.log(err));
        }
    }
}
</script>

<style lang="css" scoped>
</style>