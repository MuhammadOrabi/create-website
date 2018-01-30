<template>
    <section>
        <b-field>
            <b-input placeholder="Filter by Title Or Tags Or Created at" type="search" icon-pack="fa" icon="search" v-model="key"></b-input>
        </b-field>
        <b-table :data="filtered" :mobile-cards="true">
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

                <b-table-column field="created_at" label="Created at">
                    {{ props.row.created_at }}
                </b-table-column>

                <b-table-column label="Actions">
                    <courses-crud r u d :address="address" :token="token" @getData="getData" :sectionid="props.row.id + ''"></courses-crud>              
                </b-table-column>
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
                <courses-crud c :address="address" :token="token" @getData="getData" :id="id"></courses-crud>
            </template>
        </b-table>
    </section>
</template>

<script>
import moment from "moment";
import * as JsSearch from 'js-search';
const _ = window._;

export default {
    name: 'Courses',
    props: ['id', 'address', 'token'],
    data() {
        return {
            courses: [],
            key: ''
        };
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
        moment,
        getData() {
            window.axios.get('/api/dashboard/pages/' + this.id, { headers: { 'Authorization': 'Bearer ' + this.token } })
            .then((res) => {
                this.courses = [];
                res.data.sections.forEach((section) => {
                    let tags = _.pluck(_.where(section.extras, {type: 'tag'}), 'content');
                    let title = section.title;
                    let lessons = section.contents ? section.contents.length : 0;
                    this.courses.push(
                        {id: section.id, title: title, tags: tags, lessons: lessons, created_at: moment(section.created_at).calendar()}
                    );
                });
            })
            .catch(err => console.log(err));
        }
    }
}
</script>

<style lang="css" scoped></style>
