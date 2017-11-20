<template>
	<v-app>
		<v-snackbar :timeout="6000" top :color="context" v-model="snackbar" >
      		{{ msg }}
      		<v-btn dark flat @click="snackbar = false">Close</v-btn>
		</v-snackbar>
	  	<v-tabs dark fixed centered>
      		<v-tabs-bar class="grey" >
        		<v-tabs-slider class="yellow"></v-tabs-slider>
    			<v-tabs-item href="#tab-1" >
      				My Images
    			</v-tabs-item>
    			<v-tabs-item href="#tab-2" >
      				Look for images
    			</v-tabs-item>
      		</v-tabs-bar>
	    	<v-tabs-items>
	      		<v-tabs-content id="tab-1" class="pt-3">
	        		<v-card>
	        			<v-card-actions>
	        				<v-select label="Filter" :items="items" v-model="filtereBy" v-if="images.length > 1"></v-select>
	        				<v-spacer></v-spacer>
	        				<v-flex >
								<v-btn round color="blue-grey white--text" @click="onPickFile" :disabled="loading">
									Browse
									<v-icon right >file_upload</v-icon>
								</v-btn>
								<input type="file" style="display: none" ref="fileInput" accept="image/*" @change="onFilePicked">
							</v-flex>
	        			</v-card-actions>
	        			<v-dialog v-model="dialog" max-width="50%" scrollable>
					      	<v-card>
					      		<v-card-actions v-if="upload">
					      			<v-btn :loading="loading" :disabled="loading" color="warning white--text"
										  round  @click="uploadImage" v-if="img">
										Upload
										<span slot="loader">Uploading...</span>
										<v-icon right dark>cloud_upload</v-icon>
									</v-btn>
					      		</v-card-actions>
					      		<img :src="imgFile" max-width="100%" height="100%">
					      	</v-card>
					    </v-dialog>
					    <v-container fluid v-bind="{ ['grid-list-xl']: true }" v-if="images.length > 0">
					    	<v-layout row wrap>
					            <v-flex xs4 v-for="img in images" :key="img.id">
					              	<v-card flat tile>
					                	<v-card-media class="image" :src="img.url" height="150px" @click="useImage(img)"></v-card-media>
					              	</v-card>
					            </v-flex>
					        </v-layout>
					  	</v-container>
	        		</v-card>
	      		</v-tabs-content>
	      		<v-tabs-content id="tab-2" >
	        		<v-card>
	        			<v-card-actions>
	      					<v-text-field solo label="Search" append-icon="search" v-model="search" @keyup.enter="googleSearch"></v-text-field>
	        			</v-card-actions>
	        			 <v-container fluid v-bind="{ ['grid-list-xl']: true }" v-if="searchImages.length > 0">
					    	<v-layout row wrap>
					            <v-flex xs4 v-for="(img, i) in searchImages" :key="i" v-if="img[0].src">
					              	<v-card flat tile>
					                	<v-card-media class="image" :src="img[0].src" height="150px" @click="useImage(img)"></v-card-media>
					              	</v-card>
					            </v-flex>
					        </v-layout>
					  	</v-container>
	        		</v-card>
	      		</v-tabs-content>
    		</v-tabs-items>
	  	</v-tabs>
	</v-app>
</template>

<script>
import _ from 'underscore';

export default {

  	name: 'Media',
  	props: ['token', 'address', 'parent', 'index', 'type'],
  	data () {
    	return {
    		search: '',
    		items: [],
			filtereBy: '',
			img: '',
			loading: false,
			dialog: false,
			imgFile: '',
			images: [],
			snackbar: false,
  			context: '',
  			msg: '',
  			searchImages: [],
  			upload: true
    	}
  	},
  	mounted() {
  		this.getImgs();
  	},
  	methods: {
  		onPickFile() {
  			this.$refs.fileInput.click();
  		},
  		onFilePicked(event) {
  			const file = event.target.files[0];
  			let filename = file.name;
  			if (filename.lastIndexOf('.') <= 0) {
  				return alert('Please add a valid file!');
  			}
  			const fileReader = new FileReader();
  			fileReader.addEventListener('load', () => {
  				this.imgFile = fileReader.result;
  			});
  			fileReader.readAsDataURL(file);
  			this.img = file;
  			this.upload = true;
			this.dialog = true;
  		},
  		uploadImage() {
			  this.loading = true;
  			let date = new Date();
	    	let fileName = process.env.NODE_ENV + '/' +this.address + '/' + date.toDateString() + '/' + this.img.name;
	    	let upload = window.firebase.storage().ref(fileName).put(this.img);
	    	upload.on('state_changed', (snapshot) => {
				this.progress = Math.trunc((snapshot.bytesTransferred / snapshot.totalBytes) * 100);
			},
			(err) => console.log(err),
			() => this.saveImg(upload.snapshot.downloadURL.toString()));
	    },
	    saveImg(img) {
	    	const vm = this;
	  		window.axios.post('/api/imgs', {img: img, address: vm.address}, { headers: { 'Authorization': 'Bearer ' + vm.token } })
	      	.then(res => {
	      		if (res.data.msg === 'success') {
	      			this.dialog = false;
	      			this.snackbar = true;
	      			this.context = 'success';
	      			this.msg = 'Uploaded Successfully';
	      			this.loading = false;
	      			this.getImgs();
	      		}
	      	})
	      	.catch(err => console.log(err));
	    },
  		getImgs() {
  			window.axios.get('/api/imgs/' + this.address, { headers: { 'Authorization': 'Bearer ' + this.token }})
  			.then((res)=>{
  				this.images = res.data;
  			})
  			.catch(err => console.log(err));
  		},
  		googleSearch() {
  			if (this.search.trim() === '') return;
  			window.axios.get('http://127.0.0.1:5000/'+ this.search)
  			.then(res => {
  				let data = _.pluck(res.data, 'pagemap');
  				this.searchImages = _.compact(_.pluck(data, 'cse_image'));
  			})
  			.catch(err => console.log(err));
  		},
  		useImage(img) {
  			let url = img.url;
  			if (this.type === 'dialog') {
	  			this.parent._self.items[this.index].imgDialog = false;
	  			this.parent._self.items[this.index].img = url;
  			} else if (this.type === 'form') {
  				this.parent._self.imgDialog = false;
	  			this.parent._self.imgUrl = url;
  			} else if (this.type === 'avatar') {
  				this.parent._self.avatarDialog = false;
	  			this.parent._self.avatar = url;
  			} else {
  				this.upload = false;
  				this.dialog = true;
  				this.imgFile = url;
  			}
  		}
  	}
}
</script>

<style lang="css" scoped>
	.image {
		cursor: pointer;
	}
</style>