<template>
    <div class="container m-b-100">
        <figure class="image is-16by9" v-if="home.showcase && home.img">
            <img :src="home.img">
        </figure>
        <div class="columns">
            <div class="column" v-if="home.courses">
                <h1 class="is-5 title">Leatest Courses</h1>
                <div class="box m-t-10" v-for="(course, i) in courses" :key="i" v-if="i < 5">
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
            </div>
            <div class="column" v-if="home.articles">
                <h1 class="is-5 title">Leatest Articles</h1>
                <div class="box m-t-10" v-for="(article, i) in articles" :key="i" v-if="i < 5">
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
            </div>
        </div>
    </div>
</template>

<script>

import moment from 'moment';
export default {
    name: 'Home',
    props: ['address', 'id'],
    data () {
        return {
            home: {
                showcase: false,
                articles: false,
                courses: false,
                img: null
            },
            articles: [],
            courses: [],
        }
    },
    mounted() {
        this.getData();
    },
    methods: {
        getData() {
            window.axios.get('/api/pages/' + this.id)
            .then(res => {
                if (res.data.page.site.address !== this.address) {return;}
                this.home.articles = _.findWhere(res.data.page.sections, {title: 'articles'}).active;
                this.home.courses = _.findWhere(res.data.page.sections, {title: 'courses'}).active;
                let showcase = _.findWhere(res.data.page.sections, {title: 'showcase'});
                this.home.showcase = showcase.active;
                let img = _.findWhere(showcase.contents, {type: 'img'});
                this.home.img = img ? img.content : null;
                let articles = res.data.articles;
                let courses = res.data.courses;
                this.coursesData(courses);
                this.articlesData(articles);
            })
            .catch(err => console.log(err));
        },
        coursesData(courses) {
            courses.sections.forEach(course => {
                let tags = _.pluck(_.where(course.extras, {type: 'tag'}), 'content');
                let p = _.findWhere(course.extras, {type: 'paragraph'});
                let img = _.findWhere(course.extras, {type: 'img'}) ? 
                                _.findWhere(course.extras, {type: 'img'}).content : null;
                this.courses.push({
                        id: course.id, title: course.title, paragraph: p.content,img: img,
                        tags: tags, created_at: moment(course.created_at).calendar()
                    });
            });
        },
        articlesData(articles) {
            articles.sections.forEach(section => {
                let tags = _.pluck(_.where(section.extras, {type: 'tag'}), 'content');
                let img = _.findWhere(section.contents, {type: 'img'}) ? 
                                    _.findWhere(section.contents, {type: 'img'}).content : null;
                this.articles.push(
                    {id: section.id, title: section.title, tags: tags, img: img, created_at: moment(section.created_at).calendar()}
                );
            });
        }
    }
}
</script>

<style lang="css" scoped>
</style>