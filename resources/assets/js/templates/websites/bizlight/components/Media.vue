<template>
    <section class="card">
        <div class="card-content">
            <b-tabs type="is-boxed" expanded animated>
                <b-tab-item label="Pictures" icon-pack="fa" icon="picture-o">
                    <section class="p-t-20 columns is-multiline">
                        <div class="column is-one-quarter" v-for="(img, i) in images" :key="i">
                            <figure class="image is-square">
                                <img :src="img.url" @click="selectImg(img.url)">
                            </figure>
                        </div>
                    </section>
                    <b-modal :active.sync="isImgModalActive">
                        <p class="image is-4by3">
                            <img :src="selectedImg">
                        </p>
                    </b-modal>
                </b-tab-item>
                <b-tab-item label="Add Pictures" icon-pack="fa" icon="plus">
                    <section class="p-t-20">
                        <b-tabs position="is-centered" class="block" animated>
                            <b-tab-item label="Upload">
                                <div class="p-b-20 p-t-15 has-text-centered" v-if="imgFile">
                                    <button class="button is-success" @click="uploadImage" :disabled="uploading">Upload</button>
                                </div>
                                <div class="columns p-t-15">
                                    <section class="column" v-if="imgFile">
                                        <figure class="image is-148x148">
                                            <img :src="imgFile" alt="Placeholder image">
                                        </figure>
                                    </section>
                                    <section class="column" v-if="!uploading">
                                        <b-field>
                                            <b-upload v-model="dropFiles" @input="onPickFile" drag-drop>
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
                                    <section class="column" v-else>
                                        <progress class="progress is-primary" :value="progress" max="100">{{progress}}%</progress>
                                    </section>
                                </div>
                            </b-tab-item>
                            <b-tab-item label="Search">
                                <section class="p-t-15">
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
    </section>
</template>

<script>
    export default {
        name: 'Media',
        props: ['address', 'token', 'imgUrl', 'active'],
        data() {
            return {
                images: [],
                dropFiles: [],
                imgFile: null,
                uploading: false,
                progress: null,
                selectedImg: null,
                isImgModalActive: false
            };
        },
        computed: {},
        mounted() {
            this.getImgs();
        },
        methods: {
            getImgs() {
                window.axios.get('/api/dashboard/imgs/' + this.address, { headers: { 'Authorization': 'Bearer ' + this.token }})
                .then((res)=>{
                    this.images = res.data;
                })
                .catch(err => console.log(err));
            },
            onPickFile() {
                const fileReader = new FileReader();
                fileReader.addEventListener('load', () => {
                    this.imgFile = fileReader.result;
                });
                fileReader.readAsDataURL(this.dropFiles[0]);
            },
            deleteDropFile(index) {
                this.dropFiles.splice(index, 1);
                this.imgFile = null;
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
                window.axios.post('/api/dashboard/imgs', {img: img, address: vm.address}, { headers: { 'Authorization': 'Bearer ' + vm.token } })
                .then(res => {
                    if (res.data.msg === 'success') {
                        this.uploading = false;
                        this.loading = false;
                        this.$toast.open({
                            message: 'Uploaded Successfully',
                            type: 'is-success'
                        });
                        this.getImgs();
                    }
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
            selectImg(img) {
                if (this.active) {
                    this.$emit('update:imgUrl', img);
                    this.$emit('update:active', false);
                } else {
                    this.selectedImg = img;
                    this.isImgModalActive = true;
                }
            }
        }
    }
</script>

<style lang="css" scoped></style>
