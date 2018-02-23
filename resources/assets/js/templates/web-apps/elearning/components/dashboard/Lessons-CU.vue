<template>
    <section>
        <h1 class="subtitle is-1">Lesson Details:</h1>
        <b-field label="Title">
            <b-input v-model.trim="data.title" placeholder="Title"></b-input>
        </b-field>
        <div class="columns">
            <div class="column">
            	<b-field horizontal label="Add a video">
			        <b-upload v-model="data.video" @input="onPickFile">
			            <a class="button is-primary">
			                <b-icon icon="upload"></b-icon>
			                <span>Click to Browse</span>
			            </a>
			        </b-upload>
			        <div v-if="data.video && data.video.length">
			            <span class="file-name">
			                {{ data.video[0].name }}
			            </span>
			        </div>
			    </b-field>
			    <progress class="progress is-primary" :value="progress" max="100" v-if="progress">{{ progress }}%</progress>
            </div>
            <div class="column" v-if="videoFile">
            	<video :src="videoFile" controls preload="auto"></video>
            </div>
        </div>
        <b-field label="Description">
            <froala :config="paragraphConfig" v-model.trim="data.paragraph"></froala>
        </b-field>
        <button class="button is-primary" v-if="c" @click="uploadVideoThenDoOperation" :disabled="!validCreate">Create</button>
        <button class="button is-primary" v-if="u" @click="uploadVideoThenDoOperation" :disabled="!validUpdate">Update</button>
    </section>
</template>

<script>
    export default {
        name: 'Lessons-CU',
        props: {c: Boolean, u: Boolean, address: String, token: String, id: String, sectionid: String},
        data() {
            return {
            	data: {
            		title: '',
            		paragraph: '',
            		video: []
            	},
            	videoFile: null,
            	progress: null,
            	paragraphConfig: {
					placeholderText: 'Paragraph!',
					charCounterCount: true,
					charCounterMax: 6000,
					imageUpload: false,
					fileUpload: false,
					// toolbarInline: true,
					toolbarButtons: [
						'fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript',  'fontFamily', 'fontSize', 'color', 
						'inlineStyle', 'paragraphStyle',  'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'insertLink','help', 
						'html',  'undo', 'redo'
					],
					quickInsertButtons: ['ul', 'ol'],
					toolbarVisibleWithoutSelection: true
				},
            };
        },
        computed: {
        	validCreate() {
        		return this.data.title !== '' && this.data.paragraph !== '' && this.data.video.length;
        	},
        	validUpdate() {
        		return this.data.title !== '' || this.data.paragraph !== '' || this.data.video.length;
        	}
        },
        mounted() {
        	if (this.u) {
        		this.getData();
        	}
        },
        methods: {
        	getData() {
        		const vm = this;
                window.axios.get('/api/dashboard/contents/' + vm.id, { headers: { 'Authorization': 'Bearer ' + vm.token } })
                .then(res => {
                	console.log(res.data);
                    let content = res.data;
                    this.data.title = content.title;
                    this.data.paragraph = content.content;
                    this.videoFile = _.findWhere(content.extras, {type: 'video'}).content;
                })
                .catch(err => console.log(err));
        	},
        	onPickFile() {
                const fileReader = new FileReader();
                fileReader.addEventListener('load', () => {
                    this.videoFile = fileReader.result;
                });
                fileReader.readAsDataURL(this.data.video[0]);
            },
            uploadVideoThenDoOperation() {
        		this.$loading.open();
        		if (this.data.video.length === 0 && this.u) {
        			return this.update(this.videoFile);
        		}
				let date = new Date();
				let fileName = process.env.NODE_ENV + '/' +this.address + '/' + date.toDateString() + '/' + this.data.video[0].name;
				let upload = window.firebase.storage().ref(fileName).put(this.data.video[0]);
				upload.on('state_changed', (snapshot) => {
					this.progress = Math.trunc((snapshot.bytesTransferred / snapshot.totalBytes) * 100);
				},
				(err) => console.log(err),
				() => {
					if (this.c) {
						this.create(upload.snapshot.downloadURL.toString());
					} else if (this.u) {
						this.update(upload.snapshot.downloadURL.toString());
					}
				});
			},
        	create(videoLink) {
        		const vm = this;
        		let data = {title: vm.data.title, paragraph: vm.data.paragraph, video: videoLink};
                window.axios.post('/api/dashboard/contents/' + vm.sectionid, data, { headers: { 'Authorization': 'Bearer ' + vm.token } })
                .then((res) => {
                   	this.$toast.open({
                        duration: 5000,
                        message: 'Created Successfully',
                        position: 'is-top',
                        type: 'is-success'
                    });
                    window.location = '/dashboard/lessons/' + this.sectionid + '/' + this.address;
                })
                .catch(err => console.log(err));
        	},
        	update(videoLink) {
        		const vm = this;
        		let data = {title: vm.data.title, paragraph: vm.data.paragraph, video: videoLink};
                window.axios.put('/api/dashboard/contents/' + vm.id, data, { headers: { 'Authorization': 'Bearer ' + vm.token } })
                .then(() => {
                   	this.$toast.open({
                        duration: 5000,
                        message: 'Updated Successfully!',
                        position: 'is-top',
                        type: 'is-success'
                    });
                    window.location = '/dashboard/lessons/' + this.sectionid + '/' + this.address;
                })
                .catch(err => console.log(err));
        	}
        }
    }
</script>

<style lang="css" scoped></style>
