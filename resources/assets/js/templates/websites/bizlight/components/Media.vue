<template>
    <section class="card m-t-50">
        <b-message title="Success"  type="is-success" has-icon :active.sync="isMessageActive" closable>
            <p v-text="`You can use this image again in another website using these labels ${this.labels.toLocaleString()}`"></p>
        </b-message>
        <b-modal :active.sync="isImgModalActive">
            <p class="image is-4by3">
                <img :src="selectedImg">
            </p>
        </b-modal>
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
                </b-tab-item>
                <b-tab-item label="Add Pictures" icon-pack="fa" icon="plus">
                    <section class="p-t-20">
                        <div class="columns">
                            <section class="column">
                                <div class="columns"> 
                                    <div class="column is-one-fifth" v-if="imgFile">
                                        <button class="button is-success" @click="uploadImage" :disabled="uploading">Upload</button>
                                    </div>
                                    <b-field v-if="!uploading" class="column is-one-third">
                                        <b-upload v-model="files" @input="onPickFile">
                                            <a class="button is-primary">
                                                <b-icon icon="upload"></b-icon>
                                                <span>Browse</span>
                                            </a>
                                        </b-upload>
                                        <div v-if="files && files.length">
                                            <span class="file-name">
                                                {{ files[0].name }}
                                            </span>
                                        </div>
                                    </b-field>
                                    <section class="column is-one-third" v-else>
                                        <progress class="progress is-primary" :value="progress" max="100">{{progress}}%</progress>
                                    </section>
                                    <section v-if="imgFile" class="column is-3by2">    
                                        <figure class="image">
                                            <img :src="imgFile" alt="Placeholder image">
                                        </figure>
                                    </section>
                                </div>
                            </section>
                        </div>
                    </section>
                    <section class="p-t-15">
                        <b-field>
                            <b-input placeholder="Search..." type="search" icon="magnify" v-model.trim="tag" expanded>
                            </b-input>
                            <p class="control">
                                <button class="button is-primary" @click="search">Search</button>
                            </p>
                        </b-field>
                    </section>
                    <section class="p-t-20 columns is-multiline">
                        <div class="column is-one-quarter" v-for="(img, i) in searchImgs" :key="i">
                            <figure class="image is-square">
                                <img :src="img.url" @click="selectImg(img.url)">
                            </figure>
                        </div>
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
                files: [],
                imgFile: null,
                uploading: false,
                progress: null,
                selectedImg: null,
                isImgModalActive: false,
                tag: '',
                searchImgs: [],
                labels: [],
                isMessageActive: false
            };
        },
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
                fileReader.readAsDataURL(this.files[0]);
            },
            deleteDropFile(index) {
                this.files.splice(index, 1);
                this.imgFile = null;
            },
            uploadImage() {
                this.uploading = true;
                let img = this.files[0];
                let date = new Date();
                let fileName = process.env.NODE_ENV + '/' +this.address + '/' + date.toDateString() + '/' + img.name;
                let upload = window.firebase.storage().ref(fileName).put(img);
                upload.on('state_changed', (snapshot) => {
                    this.progress = Math.trunc((snapshot.bytesTransferred / snapshot.totalBytes) * 100);
                },
                (err) => console.log(err),
                () => this.imgLabels(upload.snapshot.downloadURL.toString()));
            },
            imgLabels(img) {
                // predict the contents of an image by passing in a url
                window.clarifai.models.predict(window.Clarifai.GENERAL_MODEL, img).then(
                    res => {
                        let labels = _.pluck(res.outputs[0].data.concepts, 'name');
                        this.labels = labels;
                        let data = {img: img, address: this.address, labels: labels};
                        this.upload(data);
                    },
                    err => console.error(err)
                );
            },
            upload(data) {
                const vm = this;
                window.axios.post('/api/dashboard/imgs', data, { headers: { 'Authorization': 'Bearer ' + vm.token } })
                .then(res => {
                    if (res.data.msg === 'success') {
                        this.uploading = false;
                        this.loading = false;
                        this.$toast.open({
                            message: 'Uploaded Successfully',
                            type: 'is-success'
                        });
                        this.isMessageActive = true;
                        this.imgFile = null;
                        this.files = [];
                        this.getImgs();
                    }
                })
                .catch(err => console.log(err));
            },
            search() {
                window.axios.get('/api/imgs/'+ this.tag.toLowerCase())
                .then(res => {
                    if (!res.data[0]) return;
                    console.log(res.data[0].imgs);
                    this.searchImgs = res.data[0].imgs;
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
