<template>
	<v-container>
		<v-snackbar :timeout="6000" top :color="context" v-model="snackbar" >
			{{ msg }}
			<v-btn dark flat @click="snackbar = false">Close</v-btn>
		</v-snackbar>
		<v-card>
			<v-card-title class="headline">
				Users     
				<v-spacer></v-spacer>
				<v-text-field append-icon="search" label="Search" single-line hide-details v-model="search" ></v-text-field>
			</v-card-title>
			<v-data-table :headers="headers" :items="users" :search="search" v-model="selected" 
							selected-key="name" select-all class="elevation-1">
				<template slot="items" slot-scope="props">
					<td>
						<v-checkbox primary hide-details v-model="props.selected" ></v-checkbox>
					</td>
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
				<v-btn color="info" flat :disabled="selected.length === 0" @click="userAction(1)" >Send activation mail</v-btn>
				<v-btn color="primary" flat :disabled="selected.length === 0" @click="userAction(2)" >Activate</v-btn>
				<v-btn color="warning" flat :disabled="selected.length === 0" @click="userAction(3)" >Deactivate</v-btn>
				<v-btn color="error" flat :disabled="selected.length === 0" @click="userAction(4)" >Delete</v-btn>
				<v-spacer></v-spacer>
				<v-btn @click="addAdmin">Generate Admin Account</v-btn>
			</div>
		</v-card>
	</v-container>
</template>

<script>
export default {

	name: 'SignUp',
	props: ['address', 'token', 'id'],
	data () {
		return {
			search: '',
			selected: [],
			pagination: {},
			headers: [
				{ text: 'Name', align: 'left', value: 'name' },
				{ text: 'Title', align: 'left', value: 'title' },
				{ text: 'Email', align: 'left', value: 'email' },
				{ text: 'Active', align: 'left', value: 'active' },
			],
			users: [],
			context: '',
			snackbar: false,
			msg: ''
		}
	},
	mounted() {
		this.getData();
	},
	methods: {
		getData() {
			const vm = this;
			window.axios.get('/api/user/' + vm.address, { headers: { 'Authorization': 'Bearer ' + vm.token } })
			.then(res => {
				this.users = res.data.users;
			})
			.catch(err => console.log(err));
		},
		userAction(i) {
			const vm = this;
			let data = this.selected;
			window.axios.put('/api/user/' + vm.address + '/edit/' + i, data, { headers: { 'Authorization': 'Bearer ' + vm.token } })
			.then(res => {
				this.context = res.data;
				this.msg = res.data === 'success' ? 'Success' : 'Failed, Try again later!';
				this.snackbar = true;
				this.getData();
			})
			.catch(err => console.log(err));
		},
		addAdmin() {
			
		}
	}
}
</script>

<style lang="css" scoped>
</style>