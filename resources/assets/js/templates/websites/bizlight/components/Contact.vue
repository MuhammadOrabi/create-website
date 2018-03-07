<template>
    <section>
        <b-field>
            <b-input placeholder="Filter by Subject Or Email Or Topic Or Created at" type="search" icon-pack="fa" icon="search" v-model="key"></b-input>
        </b-field>    
        <b-table :data="filtered" :mobile-cards="true" :loading="loading">
            <template slot-scope="props">

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
    props: ['id', 'token'],
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
            window.axios.get(`/api/dashboard/pages/${this.id}`, { headers: { 'Authorization': `Bearer ${this.token}` } })
            .then(res => {
                this.messages = [];
                this.loading = false;
                res.data.sections.forEach(section => {
                    let message = _.findWhere(section.contents, {type: 'message'});
                    let name = _.findWhere(section.contents, {type: 'name'});
                    let email = _.findWhere(section.contents, {type: 'email'});
                    this.messages.push({
                        id: section.id, name: name.content, email: email.content,
                        message: message.content, created_at: moment(section.created_at).calendar()
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
            this.$modal.open(`
                <div class="box">
                    <p class="content">${message}</p>
                </div>
            `);
        },
        destroy(id) {
            window.axios.delete(`/api/dashboard/sections/${id}`, { headers: { 'Authorization': `Bearer ${this.token}` } })
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
