<template>
	<v-container>
		<v-layout row wrap>
			<v-flex >
				<v-card>
					<v-card-title class="headline">
						Messages     
						<v-spacer></v-spacer>
						<v-text-field append-icon="search" label="Search" single-line hide-details v-model="search" ></v-text-field>
					</v-card-title>
					<v-data-table :headers="headers" :items="items" :search="search" class="elevation-1">
						<template slot="items" slot-scope="props">
							<tr @click="props.expanded = !props.expanded">
								<td class="">{{ props.item.name }}</td>
								<td class="">{{ props.item.email }}</td>
								<td class="">{{ props.item.date }}</td>
								<td>
									<v-btn color="error" @click="del(props.item.id)">Delete</v-btn>
								</td>	
							</tr>
						</template>
						<template slot="expand" slot-scope="props">
							<v-card flat>
								<v-card-text>{{ props.item.msg }}</v-card-text>
							</v-card>
						</template>
						<template slot="pageText" slot-scope="{ pageStart, pageStop }">
							From {{ pageStart }} to {{ pageStop }}
						</template>
					</v-data-table>
				</v-card>
			</v-flex>
		</v-layout>
	</v-container>
</template>

<script>
import moment from 'moment';
import _ from 'underscore';
export default {

	name: 'Contact',
	props: ['address', 'token', 'id'],
	data () {
		return {
			headers: [
				{ text: 'Name', align: 'left', value: 'name' },
				{ text: 'Email', align: 'left', value: 'email' },
				{ text: 'Date', align: 'left', value: 'date' },
			],
			items: [],
			search: '',
			delDialog: false
		}
	},
	mounted() {
		this.getData();
	},
	methods: {
		getData() {
			const vm = this;
			window.axios.get('/api/pages/' + this.id, { headers: { 'Authorization': 'Bearer ' + vm.token } })
			.then((res)=>{
				this.items = [];
				res.data.page.sections.forEach((section) => {
					let name = _.findWhere(section.contents, {type: 'name'});
					let email = _.findWhere(section.contents, {type: 'email'});
					let msg = _.findWhere(section.contents, {type: 'message'});
					let date = moment(section.created_at).calendar();
					this.items.push({id: section.id, name: name.content, msg: msg.content, email: email.content, date: date});
				});
			})
			.catch(err => console.log(err));
		},
		del(id) {
			const vm = this;
			window.axios.delete(`/api/sections/${id}` ,{ headers: { 'Authorization': 'Bearer ' + vm.token } })
			.then(res => {
				this.getData();
				this.snackbar = true;
				this.context = res.data;
				this.msg = res.data;
			}).catch(err => console.log(err));
		}
	}
}
</script>

<style lang="css" scoped>
</style>