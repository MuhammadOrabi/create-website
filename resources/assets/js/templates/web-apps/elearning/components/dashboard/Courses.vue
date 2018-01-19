<template>
    <section>
        <b-table :data="courses" detailed detail-key="id" :mobile-cards="true">
            <template slot-scope="props">
                <b-table-column field="title" label="Title">
                    {{ props.row.title }}
                </b-table-column>

                <b-table-column field="tags" label="Tags">
                    {{ props.row.tags.toLocaleString() }}
                </b-table-column>

                <b-table-column label="Lessons">
                    {{ props.row.lessons }}
                    <a :href="`/dashboard/lessons/${props.row.id}/${address}`" class="button is-link is-rounded is-inverted">
                        <b-icon pack="fa" icon="cog"></b-icon>
                    </a>
                </b-table-column>

                <b-table-column label="Created at">
                    {{ moment(props.row.created_at).calendar() }}
                </b-table-column>

                <b-table-column label="Actions">
                    <courses-crud r u d :address="address" :token="token" :parent="parent" :sectionid="props.row.id + ''"></courses-crud>              
                </b-table-column>
            </template>

            <template slot="detail" slot-scope="props">
                <article class="media">
                    <figure class="media-left">
                        <p class="image is-64x64">
                            <!-- <img src="static/img/placeholder-128x128.png"> -->
                        </p>
                    </figure>
                    <div class="media-content">
                        <div class="content">
                            <p v-html="props.row.paragraph"></p>
                        </div>
                    </div>
                </article>
            </template>
            
            <template slot="empty">
                <section class="section">
                    <div class="content has-text-grey has-text-centered">
                        <p>
                            <b-icon icon="emoticon-sad" size="is-large"></b-icon>
                        </p>
                        <p>You don't have any Courses!, Create Course Here</p>
                        <p>
                            <b-icon icon="arrow-down" size="is-large"></b-icon>
                        </p>
                    </div>
                </section>
            </template>
            <template slot="footer">
                <courses-crud c :address="address" :token="token" :parent="parent" :id="id"></courses-crud>
            </template>
        </b-table>
    </section>
</template>

<script>
    import moment from "moment";
    const _ = window._;
    export default {
        name: 'Courses',
        props: ['id', 'address', 'token'],
        data() {
            return {
                courses: [],
            };
        },
        computed: {
            parent() {
                return this;
            }
        },
        mounted() {
            this.getData();
        },
        methods: {
            moment,
            getData() {
                window.axios.get('/api/dashboard/pages/' + this.id, { headers: { 'Authorization': 'Bearer ' + this.token } })
                .then((res) => {
                    this.courses = [];
                    res.data.sections.forEach((section) => {
                        let tags = _.pluck(_.where(section.extras, {type: 'tag'}), 'content');
                        let p = _.findWhere(section.extras, {type: 'paragraph'});
                        let title = section.title;
                        let lessons = section.contents ? section.contents.length : 0;
                        this.courses.push(
                            {id: section.id, title: title, paragraph: p.content, tags: tags, lessons: lessons, created_at: section.created_at}
                        );
                    });
                })
                .catch(err => console.log(err));
            }
        }
    }
</script>

<style lang="css" scoped></style>
