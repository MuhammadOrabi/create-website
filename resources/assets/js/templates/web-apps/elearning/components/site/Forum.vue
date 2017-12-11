<template>
    <v-container>
		<v-snackbar :timeout="6000" top :color="context" v-model="snackbar" >
			{{ msg }}
			<v-btn dark flat @click="snackbar = false">Close</v-btn>
		</v-snackbar>
		<v-card>
			<v-card-title class="headline">
				Forum     
				<v-spacer></v-spacer>
				<v-text-field append-icon="search" label="Search" single-line hide-details v-model="search" ></v-text-field>
			</v-card-title>
			<v-data-table :headers="headers" :items="questions" :search="search" >
				<template slot="items" slot-scope="props">
					<td class="">{{ props.item.name }}</td>
					<td class="text-xs-">{{ props.item.title }}</td>
					<td class="text-xs-">{{ props.item.email }}</td>
					<td class="text-xs-">{{ props.item.active }}</td>
				</template>
				<template slot="pageText" slot-scope="{ pageStart, pageStop }">
					From {{ pageStart }} to {{ pageStop }}
				</template>
			</v-data-table>
			<div class="text-xs-center pt-2">
                <CRUDForum c :address="address" :id="id" :parent="parent"></CRUDForum>
			</div>
		</v-card>
	</v-container>
</template>

<script>
    import CRUDForum from './CRUD-Forum.vue';
    export default {
        name: 'Forum',
        props: ['address', 'id'],
        components: {CRUDForum},
        data() {
            return {
                search: '',
                pagination: {},
                headers: [
                    { text: 'Name', align: 'left', value: 'name' },
                    { text: 'Title', align: 'left', value: 'title' },
                    { text: 'Email', align: 'left', value: 'email' },
                    { text: 'Active', align: 'left', value: 'active' },
                ],
                questions: [],
                context: '',
                snackbar: false,
                msg: ''
            };
        },
        computed: {
            auth() {
                return this.$store.getters.session(this.address);
            },
            token() {
                return this.auth.token;
            },
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
                window.axios.get('/api/sections/' + this.id, { headers: { 'Authorization': 'Bearer ' + vm.token } })
                .then(res => {
                    console.log(res.data);
                })
                .catch(err => console.log(err));
                
            },
            ask() {
                
            }
        }
    }
</script>

<style lang="css" scoped>

</style>


