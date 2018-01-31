<template>
    <section class="flex-container">
        <b-field>
            <b-input placeholder="Search..." type="search" icon-pack="fa" icon="search" v-model="key"></b-input>
        </b-field>
        <div class="box m-t-10" v-for="article in filtered" :key="article.id">
            <article class="media">
                <div class="media-left" v-if="article.img">
                    <figure class="image is-64x64">
                        <img :src="article.img" alt="Image">
                    </figure>
                </div>
                <div class="media-content">
                    <div class="content">
                        <p>
                            <strong>{{ article.title }}</strong>
                            <br>
                            <span class="tag is-light">{{ article.created_at }}</span>
                            <br>
                            <span class="tag is-dark m-l-5 m-t-20" v-for="(tag, i) in article.tags" :key="i">{{ tag }}</span>
                        </p>
                    </div>
                    <nav class="level is-mobile">
                        <div class="level-left"></div>
                        <div class="level-right">
                            <a class="level-item" :href="`/s/${address}/article/${article.id}`">
                                View Article
                                <span class="icon"><i class="fa fa-long-arrow-right"></i></span>
                            </a>
                        </div>
                    </nav>
                </div>
            </article>
        </div>        
    </section>
</template>

<script>
import moment from 'moment';
import * as JsSearch from 'js-search';

export default {
    name: 'Articles',
    props: ['address', 'id'],
    data () {
        return {
            articles: [],
            key: ''
        }
    },
    computed: {
        filtered() {
            if (this.key) {
                let search = new JsSearch.Search('id');
                search.addIndex('title');
                search.addIndex('tags');
                search.addIndex('created_at');
                search.addDocuments(this.articles);
                return search.search(this.key);
            } else {
                return this.articles;
            }
        }
    },
    mounted() {
        this.getData();
    },
    methods: {
        getData() {
            window.axios.get('/api/pages/' + this.id)
            .then(res => {
                this.articles = [];
                res.data.sections.forEach(section => {
                    let tags = _.pluck(_.where(section.extras, {type: 'tag'}), 'content');
                    let img = _.findWhere(section.contents, {type: 'img'}) ? 
                                        _.findWhere(section.contents, {type: 'img'}).content : null;
                    this.articles.push(
                        {id: section.id, title: section.title, tags: tags, img: img, created_at: moment(section.created_at).calendar()}
                    );
                });
            })
            .catch(err => console.log(err))
        }
    }
}
</script>

<style lang="css" scoped>
</style>