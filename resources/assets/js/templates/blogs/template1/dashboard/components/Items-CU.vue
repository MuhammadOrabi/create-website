<template>
    <section>
        <h1 class="subtitle is-1">Items Details:</h1>
        <b-field label="Title">
            <b-input v-model.trim="data.title" placeholder="Title"></b-input>
        </b-field>
        <div class="column">
            <article class="media">
                <div class="media-left notification" v-if="data.img">
                    <button class="delete" @click="data.img = null"></button>
                    <figure class="image is-128x128">
                        <img :src="data.img" alt="Image">
                    </figure>
                </div>
                <div class="media-content" v-else>
                    <div class="content">
                        <button class="button is-small is-primary is-rounded" @click="isMediaModalActive = true">Add Show Case Image</button>
                    </div>
                </div>
            </article>
        </div>
        <b-modal :active.sync="isMediaModalActive" >
            <media v-bind="mediaProps" :imgUrl.sync="data.img" :active.sync="isMediaModalActive"></media>
        </b-modal>
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
            <div class="column notification" v-if="videoFile">
                <button class="delete" @click="videoFile = null"></button>
            	<video :src="videoFile" controls preload="auto"></video>
            </div>
        </div>
        <b-field label="Description">
            <b-input type="textarea" v-model="data.paragraph"></b-input>
        </b-field>
        <button class="button is-primary" v-if="c" @click="uploadVideoThenDoOperation" :disabled="!validCreate">Create</button>
        <button class="button is-primary" v-if="u" @click="uploadVideoThenDoOperation" :disabled="!validUpdate">Update</button>
    </section>
</template>

<script>
    export default {
        name: 'Items-CU',
        props: {c: Boolean, u: Boolean, address: String, token: String, id: String, sectionid: String},
        data() {
            return {
            	data: {
            		title: '',
            		paragraph: '',
                    video: [],
                    img: null
                },
                videoFile: null,
            	progress: null,
                mediaProps: {
                    address: this.address,
                    token: this.token
                },
                isMediaModalActive: false,
            };
        },
        computed: {
        	validCreate() {
        		return this.data.title !== '' && this.data.paragraph !== '';
        	},
        	validUpdate() {
        		return this.data.title !== '' || this.data.paragraph !== '';
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
                    let content = res.data;
                    this.data.title = content.title;
                    this.data.paragraph = content.content;
                    let video = _.findWhere(content.extras, {type: 'video'});
                    this.videoFile = video ? video.content : null;
                    let img = _.findWhere(content.extras, {type: 'img'});
                    this.data.img = img ? img.content : null;                    
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
        		} else if (!this.data.video.length) {
        			return this.create(null);                    
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
                let data = { title: this.data.title, paragraph: this.data.paragraph, img: this.data.img, video: videoLink};
                window.axios.post('/api/dashboard/contents/' + vm.sectionid, data, { headers: { 'Authorization': 'Bearer ' + vm.token } })
                .then((res) => {
                    console.log(res.data);
                   	this.$toast.open({
                        duration: 5000,
                        message: 'Created Successfully',
                        position: 'is-top',
                        type: 'is-success'
                    });                    
                    window.location = '/dashboard/items/' + this.sectionid + '/' + this.address;
                })
                .catch(err => console.log(err));
        	},
        	update(videoLink) {
        		const vm = this;
                let data = { title: this.data.title, paragraph: this.data.paragraph, img: this.data.img, video: videoLink};
                window.axios.put('/api/dashboard/contents/' + vm.id, data, { headers: { 'Authorization': 'Bearer ' + vm.token } })
                .then(() => {
                   	this.$toast.open({
                        duration: 5000,
                        message: 'Updated Successfully!',
                        position: 'is-top',
                        type: 'is-success'
                    });
                    window.location = '/dashboard/items/' + this.sectionid + '/' + this.address;
                })
                .catch(err => console.log(err));
        	}
        }
    }
</script>

<style lang="css" scoped></style>
