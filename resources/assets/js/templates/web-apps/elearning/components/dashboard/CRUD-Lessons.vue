<template>
  	<v-layout justify-center>
  		<v-snackbar :timeout="6000" top :color="context" v-model="snackbar" >
			{{ msg }}
			<v-btn dark flat @click="snackbar = false">Close</v-btn>
		</v-snackbar>
		<v-btn dark small color="primary" :href="`/s/${address}/lesson/${contentid}`" target="_blank" v-if="r">
    		<v-icon>visibility</v-icon>
  		</v-btn>
  		<v-btn dark small color="green" @click="getData" v-if="u">
    		<v-icon>edit</v-icon>
  		</v-btn>
  		<v-btn dark small color="indigo" @click="showCreate" v-if="c">
    		<v-icon>add</v-icon>
  		</v-btn>
  		<v-btn dark small color="red" v-if="d" @click="deleteLesson">
    		<v-icon>delete</v-icon>
  		</v-btn>
    	<v-dialog v-model="dialog" persistent max-width="70%">
      		<v-card>
		        <v-card-title>
		          	<span class="headline" style="text-transform: capitalize">{{ operation }} Lesson</span>
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
							 		<v-text-field v-model="video" label="Video"></v-text-field>
							 		<v-text-field v-model="files" label="Files"></v-text-field>
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
		          	<v-btn color="primary" v-else-if="operation == 'update'" :disabled="errors.any() || invalid" @click="update">Update</v-btn>
		        </v-card-actions>
      		</v-card>
    	</v-dialog>
  	</v-layout>
</template>

<script>
import _ from 'underscore';
export default {

  	name: 'CRUD-Lessons',
  	props: {token: String, address: String, id: String, contentid: String, c: Boolean, u: Boolean, d: Boolean, r: Boolean},
  	data () {
    	return {
    		snackbar: false,
    		context: '',
    		msg: '',
    		dialog: false,
    		operation: '',
    		title: '',
    		paragraph: '',
    		video: '',
    		files: ''
    	}
  	},
  	computed: {
  		invalid() {
  			if (this.title.trim() == '' || this.paragraph.trim() == '') {
  				return true;
	    	}
	    	return false;
  		}
  	},
  	methods: {
  		getData() {
  			const vm = this;
  			axios.get('/api/contents/' + this.contentid)
  			.then((res) => {
  				console.log(res.data);
  				let content = res.data.content;
  				this.title = content.title;
				this.paragraph = content.content;
				this.video = _.findWhere(content.extras, {type: 'video'}).content;
				this.files = _.findWhere(content.extras, {type: 'files'}).content;
				this.dialog = true;
				this.operation = 'update';
  			})
  			.catch(err => console.log(err));
  		},
  		showCreate() {
  			this.dialog = true;
			this.operation = 'create';
			this.paragraph = '';
			this.title = '';
			this.video = '';
			this.files = '';
  		},
  		create() {
  			const vm = this;
  			let data = {title: vm.title, paragraph: vm.paragraph, files: vm.files, video: vm.video};
  			axios.post(`/api/contents/${vm.id}`, data, { headers: { 'Authorization': 'Bearer ' + vm.token } })
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
  			let data = {title: vm.title, paragraph: vm.paragraph, files: vm.files, video: vm.video};
  			console.log(data);
  			return;
  			axios.put(`/api/contents/${vm.contentid}`, data, { headers: { 'Authorization': 'Bearer ' + vm.token } })
  			.then(res => {
  				this.snackbar = true;
				this.context = res.data ? 'success' : 'error';
				this.msg = res.data ? 'Saved' : 'Try Again!';
				this.dialog = res.data ? false : true;
				location.reload();
  			})
  			.catch(err => console.log(err));
  		},
  		deleteLesson() {

  		}
  	}
}
</script>

<style lang="css" scoped>
</style>