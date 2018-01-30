<template>
    <section>
        <b-field>
            <b-input placeholder="Filter by Title or Tags Or Editor Type Or Created at" type="search" icon-pack="fa" icon="search" v-model="key"></b-input>
        </b-field>
        <b-table :data="filtered" :mobile-cards="true" :loading="loading">
            <template slot-scope="props">
                <b-table-column field="title" label="Title">
                    {{ props.row.title }}
                </b-table-column>

                <b-table-column field="tags" label="Tags">
                    {{ props.row.tags.toLocaleString() }}
                </b-table-column>

                <b-table-column field="type" label="Editor Type" class="is-capitalized">
                    {{ props.row.type }}
                </b-table-column>

                <b-table-column field="created_at" label="Created at">
                    {{ props.row.created_at }}
                </b-table-column>

                <b-table-column label="Actions">
                    <a class="button is-info is-inverted" :href="`/s/${address}/article/${props.row.id}`" target="_blank">
                        <b-icon pack="fa" icon="eye"></b-icon>
                    </a>
                    <a class="button is-primary is-inverted" :href="`/dashboard/articles/update/${props.row.id}/${address}`">
                        <b-icon pack="fa" icon="pencil-square-o"></b-icon>
                    </a>
                    <span class="button is-danger is-inverted" @click="deleteDialog(props.row.id)">
                        <b-icon pack="fa" icon="trash-o"></b-icon>
                    </span>
                </b-table-column>
            </template>

            <template slot="empty" v-if="!loading">
                <section class="section">
                    <div class="content has-text-grey has-text-centered">
                        <p>
                            <b-icon icon="emoticon-sad" size="is-large"></b-icon>
                        </p>
                        <p>You don't have any articles!, Create Lesson Here</p>
                        <p>
                            <b-icon icon="arrow-down" size="is-large"></b-icon>
                        </p>
                    </div>
                </section>
            </template>
            <template slot="footer" >
                <div class="has-text-centered">
                    <a :href="`/dashboard/articles/create/${id}/${address}`" class="button is-link is-inverted" >
                        <b-icon pack="fa" icon="plus"></b-icon>
                    </a>
                </div>
            </template>
        </b-table>
    </section>
</template>

<script>
const _ = window._;
import moment from 'moment';
import * as JsSearch from 'js-search';

export default {
    name: 'Articles',
    props: ['id', 'address', 'token'],
    data() {
        return {
            articles: [],
			loading: true,
            key: ''
        };
    },
    computed: {
        filtered() {
            if (this.key) {
                let search = new JsSearch.Search('id');
                search.addIndex('title');
                search.addIndex('tags');
                search.addIndex('type');
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
    	moment,
        getData() {
            window.axios.get('/api/dashboard/pages/' + this.id, { headers: { 'Authorization': 'Bearer ' + this.token } })
            .then(res => {
            	this.articles = [];
				this.loading = false;
            	res.data.sections.forEach((section) => {
					this.articles.push({
						id: section.id,
						title: section.title,
						type: section.type,
						tags: _.pluck(_.where(section.extras, {type: 'tag'}), 'content'),
						created_at: this.moment(section.created_at).calendar()
					});						
				});
            })
            .catch(err => console.log(err));
        },
        deleteDialog(id) {
            this.$dialog.confirm({
                title: 'Deleting Article',
                message: 'Are you sure you want to <b>delete</b> this Article?<br> This action cannot be undone.',
                confirmText: 'Delete Article',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => this.destroy(id)
            });
        },
        destroy(id) {
        	const vm = this;
            window.axios.delete('/api/dashboard/sections/' + id, { headers: { 'Authorization': 'Bearer ' + vm.token } })
            .then(() => {
                this.$toast.open('Article deleted!');
                this.getData();   
            })
            .catch(err => console.log(err));
        }
    }
}
</script>

<style lang="css" scoped></style>
