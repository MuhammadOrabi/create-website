<template>
    <section>
        <section class="hero is-medium is-light is-bold">
            <div class="hero-body">
                <div class="container">
                    <article class="media">
                        <figure class="media-left" v-if="img">
                            <p class="image is-128x128">
                                <img :src="img">
                            </p>
                        </figure>
                        <div class="media-content">
                            <h1 class="title">
                                {{ title }}
                                <span class="tag is-dark m-l-10" v-for="(tag, i) in tags" :key="i" v-text="tag"></span>
                            </h1>
                            <p class="content" v-html="paragraph"></p>
                        </div>
                    </article>
                </div>
            </div>
        </section>
        <section class="section is-small is-bold m-b-100">
            <div class="container columns">
                <aside class="column menu">
                    <ul class="menu-list">
                        <li>
                            <a class="is-active">Lessons</a>
                            <ul>
                                <li v-for="lesson in lessons" :key="lesson.id">
                                    <a :href="`/s/${address}/lesson/${lesson.id}`">{{ lesson.title }}</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </aside>
                <div class="column">
                    <ul class="menu-list">
                        <li>
                            <a class="is-active">Download files</a>
                            <ul>
                                <li v-for="file in files" :key="file.id">
                                    <a :href="file.content" target="_blank" download>{{ file.title }}</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </section>
    </section>
</template>

<script>
export default {
    name: 'Course',
    props: ['id', 'address'],
    data () {
        return {
            title: '',
            paragraph: '',
            tags: [],
            img: null,
            lessons: [],
            files: []
        }
    },
    mounted() {
        this.getData();
    },
    methods: {
        getData() {
            window.axios.get('/api/sections/' + this.id)
            .then(res => {
                let course = res.data;
                if (course.page.site.address !== this.address) {return;}
                this.title = course.title;
                this.tags = _.pluck(_.where(course.extras, {type: 'tag'}), 'content');
                this.paragraph = _.findWhere(course.extras, {type: 'paragraph'}).content;
                this.img = _.findWhere(course.extras, {type: 'img'}) ? 
                                _.findWhere(course.extras, {type: 'img'}).content : null;
                this.lessons = course.contents;
                this.files = _.where(course.extras, {type: 'file'});
            })
            .catch(err => console.log(err));
        }
    }
}
</script>

<style lang="css" scoped>
</style>