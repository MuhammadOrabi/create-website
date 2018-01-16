<template>
    <section>
        <b-table :data="lessons" detailed detail-key="id" :mobile-cards="true">
            <template slot-scope="props">
                <b-table-column field="title" label="Title">
                    {{ props.row.title }}
                </b-table-column>

                <b-table-column field="tags" label="Tags">
                    {{ props.row.tags.toLocaleString() }}
                </b-table-column>

                <b-table-column label="Lessons">
                    {{ props.row.lessons }}
                    
                </b-table-column>

                <b-table-column label="Created at">
                    {{ moment(props.row.created_at).calendar() }}
                </b-table-column>

                <b-table-column label="Actions">
                    <a class="button is-info is-inverted">
                        <b-icon pack="fa" icon="eye"></b-icon>
                    </a>
                    <a class="button is-primary is-inverted">
                        <b-icon pack="fa" icon="pencil-square-o"></b-icon>
                    </a>
                    <span class="button is-danger is-inverted">
                        <b-icon pack="fa" icon="trash-o"></b-icon>
                    </span>
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
                        <p>You don't have any Lessons!, Create Lesson Here</p>
                        <p>
                            <b-icon icon="arrow-down" size="is-large"></b-icon>
                        </p>
                    </div>
                </section>
            </template>
            <template slot="footer" >
                <div class="has-text-centered">
                    <a :href="`/dashboard/lessons/create/${id}/${address}`" class="button is-link is-inverted" >
                        <b-icon pack="fa" icon="plus"></b-icon>
                    </a>
                </div>
            </template>
        </b-table>
    </section>
</template>

<script>
    const _ = window._;
    export default {
        name: 'Lessons',
        props: ['id', 'address', 'token'],
        data() {
            return {
                lessons: []
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
            getData() {
                const vm = this;
                window.axios.get('/api/dashboard/sections/' + vm.id, { headers: { 'Authorization': 'Bearer ' + vm.token } })
                .then(res => {
                    this.lessons = res.data.contents ;
                })
                .catch(err => console.log(err));
            }
        }
    }
</script>

<style lang="css" scoped></style>
