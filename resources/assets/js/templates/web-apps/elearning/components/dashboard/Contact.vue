<template>
	<v-container>
	    <v-layout row wrap>
	      	<v-flex >
	      		<v-subheader class="title">Messages</v-subheader>
	      		<v-flex xs12 class="ma-3">
		    		<v-text-field solo label="Search" prepend-icon="search" ></v-text-field>
		    	</v-flex>
	        	<v-expansion-panel popout>
	          		<v-expansion-panel-content v-for="(item, i) in items" :key="item.id">
	            		<div slot="header">{{ item.date }}</div>
	            			<v-card>
	            				<v-card-title primary-title>
						          	<div>
							            <div class="headline">{{ item.name }}</div>
							            <span class="grey--text">{{ item.email }}</span>
						          	</div>
						        </v-card-title>
	              				<v-card-text class="grey lighten-3">{{ item.msg }}</v-card-text>
	              				<v-card-actions>
		              				<v-dialog v-model="items[i].delDialog" persistent>
									      	<v-btn color="error" dark slot="activator">Delete</v-btn>
									      	<v-card>
									        	<v-card-title class="headline">are you sure you want to delete this?</v-card-title>
									        	<v-card-actions>
									          		<v-spacer></v-spacer>
									          		<v-btn flat="flat" @click="items[i].delDialog = false">Disagree</v-btn>
									          		<v-btn class="red--text darken-1" flat="flat" @click="items[i].delDialog = false; del(i)">
									          			Agree
								          			</v-btn>
									        	</v-card-actions>
									      	</v-card>
									    </v-dialog>
									</v-card-actions>
	            			</v-card>
	          		</v-expansion-panel-content>
	        	</v-expansion-panel>
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
    		items: []
    	}
  	},
  	mounted() {
  		this.getData();
  	},
  	methods: {
  		getData() {
  			const vm = this;
			axios.get('/api/sections/' + this.id, { headers: { 'Authorization': 'Bearer ' + vm.token } })
  			.then((res)=>{
  				this.items = [];
  				res.data.page.sections.forEach((section) => {
  					let name = _.findWhere(section.contents, {type: 'name'});
  					let email = _.findWhere(section.contents, {type: 'email'});
  					let msg = _.findWhere(section.contents, {type: 'message'});
  					let date = moment(section.created_at).calendar();
  					this.items.push({id: section.id, name: name.content, msg: msg.content, email: email.content, date: date,
  					 	nameId: name.id, emailId: email.id, msgId: msg.id, delDialog: false});
  				});
  			})
  			.catch(err => console.log(err));
  		},
  		del(i) {
  			const vm = this;
  			let id = vm.items[i].id;
  			axios.delete('/api/section/' + id, { headers: { 'Authorization': 'Bearer ' + vm.token } })
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