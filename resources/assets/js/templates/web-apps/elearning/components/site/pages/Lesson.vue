<template>
    <div class="flex-container p-b-100">
        <section class="section has-text-centered">
            <div class="container">
                <h1 class="title">{{ title }}</h1>
                <h2 class="subtitle">{{ course.title }}</h2>
                <video width="800" height="480" src="/img/out.ogv" controls preload="auto"></video>
            </div>
        </section>
        <div class="columns">
            <div class="column">
                <p class="content" v-html="paragraph"></p>
            </div>
            <aside class="column menu">
                <ul class="menu-list">
                    <li>
                    <a class="is-active">Lessons</a>
                        <ul class="p-t-5">
                            <li v-for="lesson in course.contents" :key="lesson.id">
                                <a :href="`/s/${address}/lesson/${lesson.id}`" :class="lesson.id +'' === id ? 'is-active' : ''">
                                    {{ lesson.title }}
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </aside>
        </div>
    </div>
</template>

<script>
export default {

    name: 'Lesson',
    props: ['address', 'id'],
    data () {
        return {
            title: '',
            paragraph: '',
            video: '',
            course: ''
        }
    },
    computed: {
        auth() {
            return this.$store.getters.session(this.address);
        }
    },
    mounted() {
        this.getData();
    },
    methods: {
        getData() {
            window.axios.get('/api/contents/' + this.id, { headers: { 'Authorization': 'Bearer ' + this.auth.token } })
                .then(res => {
                    console.log(res.data);
                    let content = res.data;
                    this.title = content.title;
                    this.paragraph = content.content;
                    this.video = _.findWhere(content.extras, {type: 'video'}).content;
                    this.course = content.contentable;
                })
                .catch(err => console.log(err));
        }
    }
}
</script>

<style lang="css" scoped>
</style>