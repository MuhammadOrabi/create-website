<template>
	<v-layout justify-center>
		<v-snackbar :timeout="6000" top :color="context" v-model="snackbar" >
			{{ msg }}
			<v-btn dark flat @click="snackbar = false">Close</v-btn>
		</v-snackbar>
		<v-btn dark small color="primary" :href="`/s/${address}/lesson/${contentid}`" target="_blank" v-if="r">
			<v-icon>visibility</v-icon>
		</v-btn>
		<v-btn dark small color="green" @click="showUpdate" v-if="u">
			<v-icon>edit</v-icon>
		</v-btn>
		<v-btn dark small color="indigo" @click="showCreate" v-if="c">
			<v-icon>add</v-icon>
		</v-btn>
		<v-btn dark small color="red" v-if="d" @click="deleteLesson">
			<v-icon>delete</v-icon>
		</v-btn>
		<v-dialog v-model="dialog" persistent max-width="100%">
			<v-card>
				<v-card-title>
					<span class="headline" style="text-transform: capitalize">{{ operation }} Lesson</span>
				</v-card-title>
				<v-card-text>
					<v-container grid-list-md>
						<form>
							<v-layout  row wrap>
								<v-flex sm5>
									<v-text-field v-model="title" label="Title" :error-messages="errors.collect('title')"
											v-validate="'required'" data-vv-name="title" required :disabled="loading" ></v-text-field>
									<v-text-field v-model="paragraph" label="Paragraph" :error-messages="errors.collect('paragraph')"
											v-validate="'required'" data-vv-name="paragraph" required multi-line :disabled="loading"></v-text-field>
									<v-btn color="primary" v-if="operation == 'update'" 
										:disabled="errors.any() || loading" @click="update(null)">Update Content</v-btn>
								</v-flex>
								<v-flex sm6 class="text-xs-center" >
									<v-btn round color="blue-grey white--text" @click="onPickVideo" :disabled="loading" :loading="loading">
										Browse Videos
										<v-icon right >file_upload</v-icon>
										<span slot="loader">Uploading...</span>
									</v-btn>
									<v-btn color="primary" v-if="operation == 'update'" 
										:disabled="loading || !videoFile" @click="uploadVideoThenDoOperation">Update Video</v-btn>				
									<v-progress-linear
										:query="true"
										v-model="progress"
										:active="loading"
										>{{ progress }}</v-progress-linear>
									<input type="file" style="display: none" ref="videoInput" accept="video/*" @change="onVideoPicked">
									<video v-if="browsedVideo" :src="browsedVideo" max-width="600px" height="330px" controls preload="auto"></video>
								</v-flex>
							</v-layout>
						</form>	
					</v-container>
					<small>*indicates required field</small>
				</v-card-text>
				<v-card-actions>
					<v-spacer></v-spacer>
					<v-btn color="blue darken-1" flat @click.native="dialog = false">Close</v-btn>
					<v-btn color="primary" v-if="operation == 'create'" :disabled="errors.any() || loading ||invalid" 
						@click="uploadVideoThenDoOperation">Create</v-btn>
				</v-card-actions>
			</v-card>
		</v-dialog>
	</v-layout>
</template>

<script>
import _ from 'underscore';

export default {

	name: 'CRUD-Lessons',
	props: {token: String, address: String, id: String, contentid: String, c: Boolean, u: Boolean, d: Boolean, r: Boolean, parent: Object},
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
			fileName: '',
			loading: false,
			progress: 0,
			videoFile: '',
			videoInput: '',
			files: '',
			browsedVideo: '',
			videoUpdate: false 
		}
	},
	computed: {
		invalid() {
			if (this.title.trim() === '' || this.paragraph.trim() === '' || !this.videoFile) {
				return true;
			}
			return false;
		}
	},
	mounted() {
		if (this.u || this.d) {
			this.getData();
		}
	},
	methods: {
		getData() {
			window.axios.get('/api/contents/' + this.contentid)
			.then((res) => {
				let content = res.data.content;
				if (content) {
					this.title = content.title;
					this.paragraph = content.content;
					this.video = _.findWhere(content.extras, {type: 'video'}).content;
					this.browsedVideo = this.video;
					this.fileName = _.findWhere(content.extras, {type: 'video'}).title;
				}
			})
			.catch(err => console.log(err));
		},
		showUpdate() {
			this.dialog = true;
			this.operation = 'update';
		},
		showCreate() {
			this.dialog = true;
			this.operation = 'create';
			this.paragraph = '';
			this.title = '';
			this.video = '';
			this.files = '';
		},
		onPickVideo() {
			this.$refs.videoInput.click();
		},
		onVideoPicked(event) {
			const file = event.target.files[0];
			let filename = file.name;
			if (filename.lastIndexOf('.') <= 0) {
				return alert('Please add a valid file!');
			}
			const fileReader = new FileReader();
			fileReader.addEventListener('load', () => {
				this.browsedVideo = fileReader.result;
			});
			fileReader.readAsDataURL(file);
			this.videoFile = file;
		},
		uploadVideoThenDoOperation() {
			this.loading = true;
			let date = new Date();
			this.fileName = process.env.NODE_ENV + '/' +this.address + '/' + date.toDateString() + '/' + this.videoFile.name;
			let upload = window.firebase.storage().ref(this.fileName).put(this.videoFile);
			upload.on('state_changed', (snapshot) => {
				this.progress = Math.trunc((snapshot.bytesTransferred / snapshot.totalBytes) * 100);
			},
			(err) => console.log(err),
			() => {
				if (this.operation === 'create') {
					this.create(upload.snapshot.downloadURL.toString())
				} else if (this.operation === 'update') {
					this.update(upload.snapshot.downloadURL.toString());
				}
			});
		},
		create(video) {
			const vm = this;
			let data = {title: vm.title, paragraph: vm.paragraph, fileName: vm.fileName, video: video};
			window.axios.post(`/api/contents/${vm.id}`, data, { headers: { 'Authorization': 'Bearer ' + vm.token } })
			.then(res => {
				this.snackbar = true;
				this.context = res.data ? 'success' : 'error';
				this.msg = res.data ? 'Saved' : 'Try Again!';
				this.dialog = res.data ? false : true;
				this.parent.getData();
			})
			.catch(err => console.log(err));
		},
		update(video) {
			const vm = this;
			let data = {};
			if (video) {
				data.video = video;
			} else {
				data = {title: vm.title, paragraph: vm.paragraph, files: vm.files};
			}
			window.axios.put(`/api/contents/${vm.contentid}`, data, { headers: { 'Authorization': 'Bearer ' + vm.token } })
			.then(res => {
				this.snackbar = true;
				this.context = res.data ? 'success' : 'error';
				this.msg = res.data ? 'Saved' : 'Try Again!';
				this.dialog = res.data ? false : true;
				this.parent._self.getData();
			})
			.catch(err => console.log(err));
		},
		deleteLesson() {
			const vm = this;
			window.firebase.storage().ref().child(this.fileName).delete()
			.then(() => {
				window.axios.delete(`/api/contents/${vm.contentid}`, { headers: { 'Authorization': 'Bearer ' + vm.token } })
				.then(res => {
					this.snackbar = true;
					this.context = res.data ? 'success' : 'error';
					this.msg = res.data ? 'Deleted' : 'Try Again!';
					this.parent._self.getData();
				})
				.catch(err => console.log(err));
			})
			.catch(err => console.log(err));
		},
	}
}
</script>

<style lang="css" scoped>
</style>