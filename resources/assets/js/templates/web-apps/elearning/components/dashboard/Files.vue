<template>
    <b-table :data="files" :mobile-cards="true" :loading="loading">
        <template slot-scope="props">
            <b-table-column field="title" label="Title">
                {{ props.row.title }}
            </b-table-column>

            <b-table-column label="Created at">
                {{ moment(props.row.created_at).calendar() }}
            </b-table-column>

            <b-table-column label="Actions">
                <a class="button is-primary is-inverted" :href="`/dashboard/files/update/${props.row.id}/${address}`">
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
                    <p>You don't have any Files!, Create Lesson Here</p>
                    <p>
                        <b-icon icon="arrow-down" size="is-large"></b-icon>
                    </p>
                </div>
            </section>
        </template>
        <template slot="footer" >
            <div class="has-text-centered">
                <a :href="`/dashboard/files/create/${id}/${address}`" class="button is-link is-inverted" >
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
        name: 'Files',
        props: ['id', 'address', 'token'],
        data() {
            return {
                files: [],
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
                    this.loading = false;
                    this.files = _.where(res.data.extras, {type: 'file'});
                })
                .catch(err => console.log(err));
            },
            deleteDialog(id) {
                this.$dialog.confirm({
                    title: 'Deleting File',
                    message: 'Are you sure you want to <b>delete</b> this File?<br> This action cannot be undone.',
                    confirmText: 'Delete File',
                    type: 'is-danger',
                    hasIcon: true,
                    onConfirm: () => this.destroy(id)
                });
            },
            destroy(id) {
            	const vm = this;
                window.axios.delete('/api/dashboard/extras/' + id, { headers: { 'Authorization': 'Bearer ' + vm.token } })
                .then(() => {
                    this.$toast.open('File deleted!');
                    this.getData();   
                })
                .catch(err => console.log(err));
            }
        }
    }
</script>

<style lang="css" scoped></style>
