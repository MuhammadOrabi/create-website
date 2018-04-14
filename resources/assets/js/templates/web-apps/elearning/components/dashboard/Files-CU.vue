<template>
    <section>
        <h1 class="subtitle is-1">File Details:</h1>
        <b-field label="Title">
            <b-input v-model.trim="data.title" placeholder="Title"></b-input>
        </b-field>
        <b-field class="file">
            <b-upload v-model="data.files">
                <a class="button is-primary">
                    <b-icon icon="upload"></b-icon>
                    <span>Click to upload</span>
                </a>
            </b-upload>
            <span class="file-name"
                v-if="data.files && data.files.length">
                {{ data.files[0].name }}
            </span>
        </b-field>
        <progress class="progress is-primary" :value="progress" max="100" v-if="progress">{{ progress }}%</progress>
        <button class="button is-primary" v-if="c" @click="uploadfileThenDoOperation" :disabled="!validCreate">Create</button>
        <button class="button is-primary" v-if="u" @click="uploadfileThenDoOperation" :disabled="!validUpdate">Update</button>
    </section>
</template>

<script>
    export default {
        name: 'Files-CU',
        props: {c: Boolean, u: Boolean, address: String, token: String, id: String, sectionid: String},
        data() {
            return {
            	data: {
                    file: [],
                    title: ''
            	},
            	fileFile: null,
            	progress: null,
            };
        },
        computed: {
        	validCreate() {
        		return this.data.title && this.data.file.length;
        	},
        	validUpdate() {
        		return this.data.title || this.data.file.length;
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
                window.axios.get('/api/dashboard/extras/' + vm.id, { headers: { 'Authorization': 'Bearer ' + vm.token } })
                .then(res => {
                    this.data.title = res.data.title;                    
                    this.fileFile = res.data.content;
                })
                .catch(err => console.log(err));
        	},
        	onPickFile() {
                const fileReader = new FileReader();
                fileReader.addEventListener('load', () => {
                    this.fileFile = fileReader.result;
                });
                fileReader.readAsDataURL(this.data.file[0]);
            },
            uploadfileThenDoOperation() {
        		this.$loading.open();
        		if (this.data.file.length === 0 && this.u) {
        			return this.update(this.fileFile);
        		}
				let date = new Date();
				let fileName = process.env.NODE_ENV + '/' +this.address + '/' + date.toDateString() + '/' + this.data.file[0].name;
				let upload = window.firebase.storage().ref(fileName).put(this.data.file[0]);
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
        	create(fileLink) {
        		const vm = this;
        		let data = {title: vm.data.title, file: fileLink};
                window.axios.post('/api/dashboard/extras/sections/' + vm.sectionid, data, { headers: { 'Authorization': 'Bearer ' + vm.token } })
                .then((res) => {
                   	this.$toast.open({
                        duration: 5000,
                        message: 'Created Successfully',
                        position: 'is-top',
                        type: 'is-success'
                    });
                    window.location = '/dashboard/files/' + this.sectionid + '/' + this.address;
                })
                .catch(err => console.log(err));
        	},
        	update(fileLink) {
        		const vm = this;
        		let data = {title: vm.data.title, file: fileLink};
                window.axios.put('/api/dashboard/extras/' + vm.id, data, { headers: { 'Authorization': 'Bearer ' + vm.token } })
                .then(res => {
                   	this.$toast.open({
                        duration: 5000,
                        message: 'Updated Successfully!',
                        position: 'is-top',
                        type: 'is-success'
                    });
                    window.location = '/dashboard/files/' + this.sectionid + '/' + this.address;
                })
                .catch(err => console.log(err));
        	}
        }
    }
</script>

<style lang="css" scoped></style>
