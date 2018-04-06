<template>
    <b-table :data="items" :mobile-cards="true" :loading="loading">
        <template slot-scope="props">
            <b-table-column field="title" label="Title">
                {{ props.row.title }}
            </b-table-column>

            <b-table-column field="video" label="Video">
            	<a class="button is-warning" :href="props.row.video" target="_blank">
                    <b-icon icon="video"></b-icon>
                </a>
            </b-table-column>

            <b-table-column label="Created at">
                {{ moment(props.row.created_at).calendar() }}
            </b-table-column>

            <b-table-column label="Actions">
                <a class="button is-info is-inverted">
                    <b-icon pack="fa" icon="eye"></b-icon>
                </a>
                <a class="button is-primary is-inverted" :href="`/dashboard/items/update/${props.row.id}/${address}`">
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
                    <p>You don't have any Lessons!, Create Lesson Here</p>
                    <p>
                        <b-icon icon="arrow-down" size="is-large"></b-icon>
                    </p>
                </div>
            </section>
        </template>
        <template slot="footer" >
            <div class="has-text-centered">
                <a :href="`/dashboard/items/create/${id}/${address}`" class="button is-link is-inverted" >
                    <b-icon pack="fa" icon="plus"></b-icon>
                </a>
            </div>
        </template>
    </b-table>
</template>

<script>
    const _ = window._;
    import moment from 'moment';
    export default {
        name: 'Items',
        props: ['id', 'address', 'token'],
        data() {
            return {
                items: [],
				loading: true
            };
        },
        mounted() {
            this.getData();
        },
        methods: {
        	moment,
            getData() {
                const vm = this;
                window.axios.get('/api/dashboard/sections/' + vm.id, { headers: { 'Authorization': 'Bearer ' + vm.token } })
                .then(res => {
                	this.items = [];
					this.loading = false;
                	res.data.contents.forEach((content) => {
						if (content.title) {
							let title = content.title;
							let video = _.findWhere(content.extras, {type: 'video'});
							this.items.push(
								{id: content.id, title: title, video: video.content, created_at: content.created_at}
							);
						}
					});
                })
                .catch(err => console.log(err));
            },
            deleteDialog(id) {
                this.$dialog.confirm({
                    title: 'Deleting Lesson',
                    message: 'Are you sure you want to <b>delete</b> this Lesson?<br> This action cannot be undone.',
                    confirmText: 'Delete Lesson',
                    type: 'is-danger',
                    hasIcon: true,
                    onConfirm: () => this.destroy(id)
                });
            },
            destroy(id) {
            	const vm = this;
                window.axios.delete('/api/dashboard/contents/' + id, { headers: { 'Authorization': 'Bearer ' + vm.token } })
                .then(() => {
                    this.$toast.open('Lesson deleted!');
                    this.getData();   
                })
                .catch(err => console.log(err));
            }
        }
    }
</script>

<style lang="css" scoped></style>
