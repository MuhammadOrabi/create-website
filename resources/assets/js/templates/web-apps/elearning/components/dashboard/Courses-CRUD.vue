<template>
    <section>
        <div class="buttons has-addons is-centered">
            <span class="button is-link is-inverted" v-if="c" @click="createModal">
                <b-icon pack="fa" icon="plus"></b-icon>
            </span>
            <a class="button is-info is-inverted" v-if="r" :href="`/s/${address}/course/${sectionid}`" target="_blank">
                <b-icon pack="fa" icon="eye"></b-icon>
            </a>
            <span class="button is-primary is-inverted" v-if="u" @click="updateModal">
                <b-icon pack="fa" icon="pencil-square-o"></b-icon>
            </span>
            <span class="button is-danger is-inverted" v-if="d" @click="deleteDialog">
                <b-icon pack="fa" icon="trash-o"></b-icon>
            </span>
        </div>
        <b-modal :active.sync="isModalActive">
            <div class="box">
                <h1 v-if="c" class="title is-1 has-text-centered">Create Course</h1>                
                <h1 v-if="u" class="title is-1 has-text-centered">Update Course</h1>                
                <div class="columns">
                    <div class="column">
                        <b-field label="Title">
                            <b-input v-model.trim="data.title" placeholder="Title"></b-input>
                        </b-field>
                        <b-field label="Add some tags">
                            <b-taginput v-model="data.tags" icon="label" placeholder="Add a tag"></b-taginput>
                        </b-field>
                    </div>
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
                </div>
                <b-modal :active.sync="isMediaModalActive" >
                    <media v-bind="mediaProps" :imgUrl.sync="data.img" :active.sync="isMediaModalActive"></media>
                </b-modal>
                <b-field label="Description" class="m-t-20">
                    <froala :config="paragraphConfig" v-model.trim="data.paragraph"></froala>
                </b-field>
                <button class="button is-primary" v-if="c" @click="create" :disabled="!valid">Create</button>
                <button class="button is-primary" v-if="u" @click="update" :disabled="!valid">Update</button>
            </div>    
        </b-modal>
    </section>
</template>

<script>
    const _ = window._;
    export default {
        name: 'Courses-CRUD',
        props: {token: String, address: String, id: String, sectionid: String, c: Boolean, u: Boolean, d: Boolean, r: Boolean},
        data() {
            return {
                isModalActive: false,
                img: null,
                data: {
                    title: '',
                    paragraph: '',
                    tags: [],
                    img: null
                },
                mediaProps: {
                    address: this.address,
                    token: this.token
                },
                isMediaModalActive: false,
                paragraphConfig: {
					placeholderText: 'Paragraph!',
					charCounterCount: true,
					charCounterMax: 6000,
					imageUpload: false,
					fileUpload: false,
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
            valid() {
                return this.data.title !== '' && this.data.paragraph !== '' && this.data.tags.length !== 0;
            }
        },
        mounted() {
            if (this.u) {
                this.getData();
            }
        },
        methods: {
            createModal() {
                this.data = {
                    title: '',
                    paragraph: '',
                    tags: [],
                    img: null
                };
                this.isModalActive = true;
            },
            updateModal() {
                this.isModalActive = true;  
            },
            deleteDialog() {
                this.$dialog.confirm({
                    title: 'Deleting Course',
                    message: 'Are you sure you want to <b>delete</b> this Course?<br> This action cannot be undone.',
                    confirmText: 'Delete Course',
                    type: 'is-danger',
                    hasIcon: true,
                    onConfirm: () => this.destroy()
                });
            },
            create() {
                const vm = this;
                window.axios.post('/api/dashboard/sections/' + vm.id, vm.data, { headers: { 'Authorization': 'Bearer ' + vm.token } })
                .then(() => {
                   this.isModalActive = false;
                   this.$toast.open({
                        duration: 5000,
                        message: 'Created Successfully',
                        position: 'is-top',
                        type: 'is-success'
                    });
                    this.$emit('getData');
                })
                .catch(err => console.log(err));
            },
            getData() {
                const vm = this;
                window.axios.get('/api/dashboard/sections/' + vm.sectionid, { headers: { 'Authorization': 'Bearer ' + vm.token } })
                .then(res => {
                    let section = res.data;
                    this.data.tags = _.pluck(_.where(section.extras, {type: 'tag'}), 'content');
                    this.data.paragraph = _.findWhere(section.extras, {type: 'paragraph'}).content;
                    let img = _.findWhere(section.extras, {type: 'img'});
                    this.data.img = img ? img.content : null;
                    this.data.title = section.title;
                    this.lessons = section.contents ? section.contents.length : 0;
                })
                .catch(err => console.log(err));
            },
            update() {
                const vm = this;
                window.axios.put('/api/dashboard/sections/' + vm.sectionid, vm.data, { headers: { 'Authorization': 'Bearer ' + vm.token } })
                .then(() => {
                    this.isModalActive = false;
                    this.$toast.open({
                        duration: 5000,
                        message: 'Updated Successfully',
                        position: 'is-top',
                        type: 'is-success'
                    });
                    this.$emit('getData');      
                })
                .catch(err => console.log(err));
            },
            destroy() {
                const vm = this;
                window.axios.delete('/api/dashboard/sections/' + vm.sectionid, { headers: { 'Authorization': 'Bearer ' + vm.token } })
                .then(() => {
                    this.$toast.open('Course deleted!');
                    this.$emit('getData');                   
                })
                .catch(err => console.log(err));
            }
        }
    }
</script>

<style lang="css" scoped></style>
