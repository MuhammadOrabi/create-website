<template>
	<v-app>
		<v-snackbar :timeout="6000" top :color="context"  v-model="snackbar" >
      		{{ msg }}
      		<v-btn dark flat @click="snackbar = false">Close</v-btn>
		</v-snackbar>
		<v-tabs dark fixed centered>
		    <v-toolbar extended class="cyan" dark>
		      	<v-toolbar-title slot="extension" class="display-2">News</v-toolbar-title>
		    </v-toolbar>
		    <v-tabs-bar class="cyan">
		      	<v-tabs-slider class="yellow"></v-tabs-slider>
		      	<v-tabs-item href="#tab-post">
		        	Post
		      	</v-tabs-item>
		      	<v-tabs-item href="#tab-update" v-if="items.length > 0">
		        	Update
		      	</v-tabs-item>
		    </v-tabs-bar>
    		<v-tabs-items>
      			<v-tabs-content id="tab-post" >
        			<v-layout row>
						<v-flex xs12>
							<h4 class="grey--text">Add News</h4>
						</v-flex>
					</v-layout>
					<v-layout row>
						<v-flex xs12>
							<form @submit.prevent="post">
								<v-layout row>
									<v-flex xs12 sm6 offset-sm3>
										<v-text-field name="title" label="Title" id="title" v-model="title" 
											v-validate="'required'" v-bind:rules="[errors.first('title') || true]"></v-text-field>
									</v-flex>
								</v-layout>
								<v-layout row>
									<v-flex xs12 sm6 offset-sm3>
										<v-dialog max-width="75%" v-model="imgDialog">
											<v-btn flat slot="activator">add Image</v-btn>
			    							<media :address="address" :token="token" type="form" :parent="parent"></media>
			    						</v-dialog>
									</v-flex>
								</v-layout>
								<v-layout row>
									<v-flex xs12 sm6 offset-sm3>
										<img :src="imgUrl" height="150">
									</v-flex>
								</v-layout>
								<v-layout row>
									<v-flex xs12 sm6 offset-sm3>
										<v-text-field name="description" label="Description" id="description" multi-line v-model="description"
											v-validate="'required'" v-bind:rules="[errors.first('description') || true]" ></v-text-field>
									</v-flex>
								</v-layout>
								<v-layout row>
									<v-flex class="text-xs-center">
										<v-btn round color="info" light :disabled="errors.any() || !formIsValid" type="submit" >Post</v-btn>
									</v-flex>
								</v-layout>
							</form>
						</v-flex>
					</v-layout>
      			</v-tabs-content>
      			<v-tabs-content id="tab-update" >
      				<v-layout v-for="(item, i) in items" :key="item.id">
					    <v-flex xs12 sm7 offset-sm1 class="mt-3">
							<v-card>
			        			<v-card-media :src="item.img" height="200px" >
			        				<v-btn icon v-if="item.show" color="error" dark fab small right absolute class="mt-2" 
			        					@click.stop="item.imgDialog = true">
			        					<v-icon>edit</v-icon>
			        				</v-btn>
			        			</v-card-media>
			        			<v-dialog v-model="item.imgDialog" max-width="75%">
			    					<media :address="address" :token="token" :index="i" :parent="parent" type="dialog"></media>
			    				</v-dialog>
			        			<v-card-title primary-title>
						          	<div>
							            <div class="headline" v-if="!item.show">{{ item.heading }}</div>
							            <v-text-field v-else v-model="items[i].heading" ></v-text-field>
							            <span class="grey--text">{{ item.date }}</span>
						          	</div>
						        </v-card-title>
			        			<v-card-actions>
						          	<v-btn flat color="success" v-if="item.show" @click="item.show = !item.show; save(i)">Save</v-btn>
						          	<v-btn flat v-else @click="item.show = !item.show">Update</v-btn>
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
						        <v-slide-y-transition>
						          	<v-card-text v-if="!item.show">{{ item.paragraph }}</v-card-text>
						          	<v-flex class="ma-3" v-else >
						          		<v-text-field v-model="items[i].paragraph" multi-line></v-text-field>
						          	</v-flex>
						        </v-slide-y-transition>
						    </v-card>
					    </v-flex>
					</v-layout>
      			</v-tabs-content>
    		</v-tabs-items>
  		</v-tabs>
	</v-app>
</template>

<script>
import _ from 'underscore';
import moment from 'moment';
export default {

  	name: 'News',
  	props: ['address', 'token', 'id'],
  	data () {
    	return {
    		imgDialog: false,
    		title: '',
    		imgUrl: '',
    		description: '',
    		image: '',
    		loading: false,
    		items: [],
    		dialog: [],
    		imgs: [],
    		snackbar: false,
    		context: '',
    		msg: ''
    	}
  	},
  	mounted() {
		this.getData();
  	},
  	computed: {
  		formIsValid() {
  			return this.title !== '' !== '' && this.imgUrl !== '' && this.description !== '';
  		},
  		parent() {
  			return this;
  		}
  	},
  	methods: {
  		getData() {
  			const vm = this;
			axios.get('/api/sections/' + this.id, { headers: { 'Authorization': 'Bearer ' + vm.token } })
  			.then((res)=>{
  				this.items = [];
  				res.data.page.sections.forEach((section) => {
  					let h = _.findWhere(section.contents, {type: 'heading'});
  					let img = _.findWhere(section.contents, {type: 'img'});
  					let p = _.findWhere(section.contents, {type: 'paragraph'});
  					let date = moment(section.created_at).calendar();
  					this.items.push({id: section.id, img: img.content, paragraph: p.content, heading: h.content, date: date,
  					 	imgId: img.id, pId: p.id, hId: h.id, show: false, imgDialog: false, delDialog: false});
  				});
  			})
  			.catch(err => console.log(err));
  		},
  		post() {
  			const vm = this;
  			let data = {title: vm.title, description: vm.description, url: vm.imgUrl}
  			axios.post('/api/sections/' + vm.id, data, { headers: { 'Authorization': 'Bearer ' + vm.token } })
	      	.then(res => {
	      		this.title = '';
	      		this.description = '';
	      		this.imgUrl = ''; 
	      		this.image = ''; 
	      		this.snackbar = true;
				this.context = res.data ? 'success' : 'error';
				this.msg = res.data ? 'Posted' : 'Try Again!';
				this.loading = false;
				this.getData();
	      	})
	      	.catch(err => console.log(err));
  		},
  		save(i) {
  			let item = this.items[i];
  			let data = [ 
  				{id: item.hId, content: item.heading},
  				{id: item.pId, content: item.paragraph},
  				{id: item.imgId, content: item.img}
  			];
  			const vm = this;
  			axios.put('/api/contents', data, { headers: { 'Authorization': 'Bearer ' + vm.token } })
			.then(res => {
				this.snackbar = true;
				this.context = res.data;
				this.msg = res.data;
			}).catch(err => console.log(err));
  		},
  		del(i) {
  			const vm = this;
  			let id = vm.items[i].id;
  			axios.delete('/api/sections/' + id, { headers: { 'Authorization': 'Bearer ' + vm.token } })
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