<template>
  	<v-layout row justify-center>
  		<v-snackbar :timeout="6000" top :color="context" v-model="snackbar" >
			{{ msg }}
			<v-btn dark flat @click="snackbar = false">Close</v-btn>
		</v-snackbar>
    	<v-dialog v-model="dialog" persistent max-width="70%">
      		<v-btn color="primary" dark slot="activator">{{ operation }} Course</v-btn>
      		<v-card>
		        <v-card-title>
		          	<span class="headline" style="text-transform: capitalize">{{ operation }} Course</span>
		        </v-card-title>
        		<v-card-text>
          			<v-container grid-list-md>
           	 			<form>
							<v-layout row wrap>
								<v-flex sm5>
						    		<v-text-field v-model="title" label="Title" :error-messages="errors.collect('title')"
					    			 		v-validate="'required'" data-vv-name="title" required ></v-text-field>
							 		<v-text-field v-model="paragraph" label="Paragraph" :error-messages="errors.collect('paragraph')"
					    			 		v-validate="'required'" data-vv-name="paragraph" required multi-line ></v-text-field>
								</v-flex>
							 	<v-flex offset-sm1 sm5>
							 		<v-text-field v-for="(tag, i) in tags" :key="i" v-model="tags[i]" label="Tag" :error-messages="errors.collect('tag')"
								 		v-validate="'required'" data-vv-name="tag" required ></v-text-field>
								 	<v-btn @click="tags.push('')">Add Tag</v-btn>
								 	<v-btn @click="tags.pop()">Remove Tag</v-btn>
							 	</v-flex>
							</v-layout>
				  		</form>	
          			</v-container>
          			<small>*indicates required field</small>
        		</v-card-text>
		        <v-card-actions>
		          	<v-spacer></v-spacer>
		          	<v-btn color="blue darken-1" flat @click.native="dialog = false">Close</v-btn>
		          	<v-btn color="primary" v-if="operation == 'create'" :disabled="errors.any() || invalid" @click="create">Create</v-btn>
		          	<v-btn color="primary" v-if="operation == 'update'" :disabled="errors.any() || invalid" @click="update">Update</v-btn>
		        </v-card-actions>
      		</v-card>
    	</v-dialog>
  	</v-layout>
</template>

<script>
import _ from 'underscore';
export default {

  	name: 'CreateUpdateCourse',
  	props: ['token', 'address', 'id', 'operation', 'sectionid'],
  	data () {
    	return {
    		title: '',
    		type: '',
    		tags: [''],
    		paragraph: '',
    		snackbar: false,
    		context: '',
    		msg: '',
    		dialog: false

    	}
  	},
  	mounted() {
  		if (this.operation == 'update') {
  			this.getData();
  		}
  	},
  	computed: {
  		invalid() {
  			if (this.title === '' || this.paragraph === '' || !this.tags[this.tags.length -1]) {
  				return true;
	    	}
	    	return false;
  		}
  	},
  	methods: {
  		getData() {
  			const vm = this;
			axios.get('/api/sections/' + this.sectionid)
  			.then((res) => {
  				let section = res.data.section;
				this.tags = _.pluck(_.where(section.extras, {type: 'tag'}), 'content');
				this.paragraph = _.findWhere(section.extras, {type: 'paragraph'}).content;
				this.title = section.title;
			})
			.catch(err => console.log(err));
  		},
  		create() {
  			const vm = this;
  			let data = {title: vm.title, paragraph: vm.paragraph, tags: vm.tags};
			axios.post('/api/sections/' + vm.id, data, { headers: { 'Authorization': 'Bearer ' + vm.token } })
			.then(res => {
				this.snackbar = true;
				this.context = res.data ? 'success' : 'error';
				this.msg = res.data ? 'Saved' : 'Try Again!';
				this.dialog = res.data ? false : true;
				location.reload();
			})
			.catch(err => console.log(err));
  		},
  		update() {
  			const vm = this;
  			let data = {title: vm.title, paragraph: vm.paragraph, tags: vm.tags};
			axios.put('/api/sections/' + vm.sectionid + '/edit', data, { headers: { 'Authorization': 'Bearer ' + vm.token } })
			.then(res => {
				this.snackbar = true;
				this.context = res.data ? 'success' : 'error';
				this.msg = res.data ? 'Saved' : 'Try Again!';
				this.dialog = res.data ? false : true;
				location.reload();
			})
			.catch(err => console.log(err));
  		}
  	}
}
</script>

<style lang="css" scoped>
</style>