<template>
    <section>
        <b-field>
            <b-input placeholder="Search..." type="search" icon-pack="fa" icon="search" v-model="key"></b-input>
        </b-field>
        <div class="box m-t-10" v-for="course in filtered" :key="course.id">
            <article class="media">
                <div class="media-left" v-if="course.img">
                    <figure class="image is-64x64">
                        <img :src="course.img" alt="Image">
                    </figure>
                </div>
                <div class="media-content">
                    <div class="content">
                        <p>
                            <strong>{{ course.title }}</strong> 
                            <span class="tag is-light">{{ course.created_at }}</span>
                            <span class="tag is-dark m-l-5" v-for="(tag, i) in course.tags" :key="i">{{ tag }}</span>
                            <br>
                            <span v-html="course.paragraph"></span>
                        </p>
                    </div>
                    <nav class="level is-mobile">
                        <div class="level-left"></div>
                        <div class="level-right">
                            <a class="level-item" :href="`/s/${address}/course/${course.id}`">
                                View Course
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
    name: 'Courses',
    props: ['address', 'id'],
    data () {
        return {
            courses: [],
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
                search.addDocuments(this.courses);
                return search.search(this.key);
            } else {
                return this.courses;
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
                this.courses = [];
                if (res.data.site.address !== this.address) {return;}
                res.data.sections.forEach(section => {
                    let tags = _.pluck(_.where(section.extras, {type: 'tag'}), 'content');
                    let p = _.findWhere(section.extras, {type: 'paragraph'});
                    let img = _.findWhere(section.extras, {type: 'img'}) ? 
                                    _.findWhere(section.extras, {type: 'img'}).content : null;
                    this.courses.push({
                            id: section.id, title: section.title, paragraph: p.content,img: img,
                            tags: tags, created_at: moment(section.created_at).calendar()
                        });
                });
            })
            .catch(err => console.log(err))
        }
    }
}
</script>

<style lang="css" scoped>
p {
    height:60px;
    line-height:20px; /* Height / no. of lines to display */
    overflow:hidden;
}
</style>