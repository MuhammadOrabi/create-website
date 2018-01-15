<template>
    <section>
        <b-table :data="users" :checked-rows.sync="selected" :paginated="true" :per-page="10" 
            default-sort-direction="desc" default-sort="created_at" :mobile-cards="true" checkable>
            <template slot-scope="props">

                <b-table-column field="name"  label="Name" sortable>
                    {{ props.row.name }}
                </b-table-column>

                <b-table-column field="title" label="Title" sortable>
                    {{ props.row.title }}
                </b-table-column>

                <b-table-column label="E-mail">
                    {{ props.row.email }}
                </b-table-column>
                
                <b-table-column field="created_at" label="Registered at" centered sortable>
                    {{ moment(props.row.created_at).calendar() }}
                </b-table-column>

                <b-table-column field="active" label="Statues" sortable>
                    {{ props.row.active }}
                </b-table-column>
            </template>
            <template slot="footer">
                <section class="has-text-centered">
                    <div v-if="selected.length" class="p-b-20">
                        <button @click="userAction(1)" class="button is-info">Send Activation E-Mail</button>
                        <button @click="userAction(2)" class="button is-primary">Activate</button>
                        <button @click="userAction(3)" class="button is-warning">De-activate</button>
                        <button @click="userAction(4)" class="button is-danger">Delete</button>
                    </div>
                    <button class="button is-link">Create Admin Account</button>
                </section>
            </template>
        </b-table>    
    </section>
</template>

<script>
    import moment from "moment";
    export default {
        name: 'Users',
        props: ['address', 'token', 'id'],
        data() {
            return {
                users: [],
                selected: []
            };
        },
        computed: {},
        mounted() {
            this.getData();
        },
        methods: {
            moment,
            getData() {
                const vm = this;
                window.axios.get('/api/dashboard/users/' + vm.address, { headers: { 'Authorization': 'Bearer ' + vm.token } })
                .then(res => {
                    this.users = res.data.users;
                })
                .catch(err => console.log(err));
            },
            userAction(i) {
                const vm = this;
                let data = this.selected;
                window.axios.put('/api/users/' + vm.address + '/edit/' + i, data, { headers: { 'Authorization': 'Bearer ' + vm.token } })
                .then(res => {
                    let context = res.data;
                    let msg = res.data === 'success' ? 'Success' : 'Failed, Try again later!';
                    this.$toast.open({
                        duration: 5000,
                        message: msg,
                        position: 'is-top',
                        type: 'is-' + context
                    });
                    this.selected = [];
                    this.getData();
                })
                .catch(err => console.log(err));
            },
            addAdmin() {
                
            },
            
        }
    }
</script>

<style lang="css" scoped></style>
