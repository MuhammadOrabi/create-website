<template>
    <div>
        <h1 class="title">Media</h1>
        <hr>
         <b-tabs type="is-toggle" expanded>
            <b-tab-item label="Pictures" icon-pack="fa" icon="picture-o"></b-tab-item>
            <b-tab-item label="Add Pictures" icon-pack="fa" icon="plus">
                <section class="p-t-20">
                    <b-tabs position="is-centered" class="block">
                        <b-tab-item label="Upload">
                            <section class="p-t-50 column is-half is-offset-4">
                                <b-field>
                                    <b-upload v-model="dropFiles"
                                        drag-drop>
                                        <section class="section">
                                            <div class="content has-text-centered">
                                                <p><b-icon pack="fa" icon="upload" size="is-large"></b-icon></p>
                                                <p>Drop your files here or click to upload</p>
                                            </div>
                                        </section>
                                    </b-upload>
                                </b-field>

                                <div class="tags">
                                    <span v-for="(file, index) in dropFiles" :key="index" class="tag is-primary" >
                                        {{file.name}}
                                        <button class="delete is-small" type="button" @click="deleteDropFile(index)"></button>
                                    </span>
                                </div>
                            </section>
                        </b-tab-item>
                        <b-tab-item label="Search">
                            <section class="p-t-50">
                                <b-field>
                                    <b-input placeholder="Search..." type="search" icon-pack="fa" icon="search"></b-input>
                                </b-field>
                            </section>
                        </b-tab-item>
                    </b-tabs>
                </section>
            </b-tab-item>
        </b-tabs>
        
    </div>
</template>

<script>
    export default {
        name: 'Media',
        props: ['address', 'token'],
        data() {
            return {
                dropFiles: [],
                uploading: false,
                progress: null
            };
        },
        computed: {},
        mounted() {},
        methods: {
            deleteDropFile(index) {
                this.dropFiles.splice(index, 1);
            },
            uploadImage() {
                this.uploading = true;
                let img = this.dropFiles[0];
                let date = new Date();
                let fileName = process.env.NODE_ENV + '/' +this.address + '/' + date.toDateString() + '/' + img.name;
                let upload = window.firebase.storage().ref(fileName).put(img);
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
                        this.uploading = false;
                        this.context = 'success';
                        this.msg = 'Uploaded Successfully';
                        this.loading = false;
                        this.getImgs();
                    }
                })
                .catch(err => console.log(err));
            },
        }
    }
</script>

<style lang="css" scoped></style>
