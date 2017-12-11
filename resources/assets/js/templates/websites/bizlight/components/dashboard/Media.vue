<template>
    <div>
        <div v-if="context" :class="`alert alert-${context}`" role="alert">Uploaded Successfully</div>
        <div class="card">
            <div class="card-header text-center">
                <ul class="nav nav-tabs nav-fill card-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" :id="`my-images${addon}-tab`" data-toggle="tab" :href="`#my-images${addon}`" 
                            role="tab" :aria-controls="`my-images${addon}`" aria-selected="true">My Images</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" :id="`search-images${addon}-tab`" data-toggle="tab" :href="`#search-images${addon}`" role="tab" 
                            :aria-controls="`search-images${addon}`" aria-selected="true">Look For Images</a>
                    </li>
                </ul>
            </div>
            <div class="card-body tab-content">
                <div class="tab-pane fade show active" :id="`my-images${addon}`" role="tabpanel" :aria-labelledby="`my-images${addon}-tab`">
                    <div class="row">
                        <div class="col" v-if="loading">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" 
                                    :style="`width: ${progress}%`" :aria-valuenow="progress" aria-valuemin="0" aria-valuemax="100">
                                    {{ progress }}%
                                </div>
                            </div>
                        </div>  
                        <div class="col" v-else>
                            <label class="custom-file">
                                <input type="file" id="file2" class="custom-file-input" accept="image/*" @change="onFilePicked">
                                <span class="custom-file-control"></span>
                            </label>
                        </div>
                        <div class="col" v-if="imgFile">
                            <img :src="imgFile" alt="Image" class="img-thumbnail" height="200px" width="200px">
                            <button class="btn btn-primary text-white" @click="uploadImage" :disabled="loading">Upload</button>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col" v-for="(image, i) in images" :key="i">
                            <div class="card" style="width: 20rem;">
                                <img class="card-img-top" :src="image.url" alt="Card image cap" @click="useImage(image.url)">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show" :id="`search-images${addon}`" role="tabpanel" :aria-labelledby="`search-images${addon}-tab`">
                    Look For Images
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Media',
        props: ['token', 'address', 'parent', 'index'],
        data() {
            return {
                imgFile: null,
                img: null,
                upload: null,
                model: false,
                loading: false,
                progress: null,
                context: null,
                images: []
            };
        },
        computed: {
            addon() {
                return this.parent? this.parent.$options._componentTag: '';
            }
        },
        mounted() {
            this.getImgs();
        },
        methods: {
            onFilePicked(event) {
                const file = event.target.files[0];
                let filename = file.name;
                if (filename.lastIndexOf('.') <= 0) {
                    return alert('Please add a valid image!');
                }
                const fileReader = new FileReader();
                fileReader.addEventListener('load', () => {
                    this.imgFile = fileReader.result;
                });
                fileReader.readAsDataURL(file);
                this.img = file;
                this.upload = true;
            },
            uploadImage() {
                let date = new Date();
                let fileName = process.env.NODE_ENV + '/' +this.address + '/' + date.toDateString() + '/' + this.img.name;
                let upload = window.firebase.storage().ref(fileName).put(this.img);
                this.loading = true;
                upload.on('state_changed', (snapshot) => {
                    this.progress = Math.trunc((snapshot.bytesTransferred / snapshot.totalBytes) * 100);
                    console.log(this.progress);
                },
                (err) => console.log(err),
                () => this.saveImg(upload.snapshot.downloadURL.toString()));
            },
            saveImg(img) {
                const vm = this;
                window.axios.post('/api/imgs', {img: img, address: vm.address}, { headers: { 'Authorization': 'Bearer ' + vm.token } })
                .then(res => {
                    if (res.data.msg === 'success') {
                        this.model = false;
                        this.context = 'success';
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
            useImage(url) {
                if (this.index !== null) {
                    console.log(this.parent._self.avail[this.index].img);
                    this.parent._self.data[this.index].img = url;
                } else {
                    this.parent._self.imgsrc = url;
                }
                this.parent._self.toggleModal();
            }
        }
    }
</script>

<style lang="css" scoped>

</style>


