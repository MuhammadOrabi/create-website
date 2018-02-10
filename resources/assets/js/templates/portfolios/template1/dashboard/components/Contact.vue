<template>
    <section>
        <b-field>
            <b-input placeholder="Filter by Subject Or Email Or Topic Or Created at" type="search" icon-pack="fa" icon="search" v-model="key"></b-input>
        </b-field>    
        <b-table :data="filtered" :mobile-cards="true" :loading="loading">
            <template slot-scope="props">
                <b-table-column field="subject" label="Subject">
                    {{ props.row.subject }}
                </b-table-column>

                <b-table-column field="name" label="Name">
                   {{ props.row.name }}
                </b-table-column>
                
                <b-table-column field="email" label="Email">
                   {{ props.row.email }}
                </b-table-column>

                <b-table-column field="created_at" label="Received at">
                    {{ props.row.created_at }}
                </b-table-column>

                <b-table-column label="Actions">
                    <span class="button is-info is-inverted" @click="show(props.row.message)">
                        <b-icon pack="fa" icon="eye"></b-icon>
                    </span>
                    <span class="button is-danger is-inverted" @click="deleteDialog(props.row.id)">
                        <b-icon pack="fa" icon="trash-o"></b-icon>
                    </span>
                </b-table-column>
            </template>
            
            <template slot="empty" v-if="!loading">
                <section class="section">
                    <div class="content has-text-grey has-text-centered">
                        <p>You don't have any messages!</p>
                    </div>
                </section>
            </template>
        </b-table>
    </section>
</template>

<script>
const _ = window._;
import moment from 'moment';
import * as JsSearch from 'js-search';

export default {
    name: 'Contact',
    props: ['id', 'address', 'token'],
    data() {
        return {
            messages: [],
            loading: true,
            key: ''
        };
    },
    computed: {
        filtered() {
            if (this.key) {
                let search = new JsSearch.Search('id');
                search.addIndex('subject');
                search.addIndex('topic');
                search.addIndex('email');
                search.addIndex('created_at');
                search.addDocuments(this.messages);
                return search.search(this.key);
            } else {
                return this.messages;
            }
        }
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
                console.log(res.data);
                this.messages = [];
                this.loading = false;
                res.data.contents.forEach(content => {
                    let info = _.findWhere(content.extras, {type: 'info'});
                    this.messages.push({
                        id: content.id, subject: content.title, message: content.content, created_at: moment(content.created_at).calendar(), 
                        name: info.title, email: info.content
                     });
                });
            })
            .catch(err => console.log(err));
        },
        deleteDialog(id) {
            this.$dialog.confirm({
                title: 'Deleting Message',
                message: 'Are you sure you want to <b>delete</b> this Message?<br> This action cannot be undone.',
                confirmText: 'Delete Message',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => this.destroy(id)
            });
        },
        show(message) {
            console.log('here');
            this.$modal.open(`
                <div class="box">
                    <p class="content">${message}</p>
                </div>
            `);
        },
        destroy(id) {
            const vm = this;
            window.axios.delete('/api/dashboard/contents/' + id, { headers: { 'Authorization': 'Bearer ' + vm.token } })
            .then(() => {
                this.$toast.open('Message deleted!');
                this.getData();   
            })
            .catch(err => console.log(err));
        }
    }
}
</script>

<style lang="css" scoped></style>
