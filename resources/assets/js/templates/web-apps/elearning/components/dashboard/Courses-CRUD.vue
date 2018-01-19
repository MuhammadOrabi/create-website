<template>
    <section>
        <div class="buttons has-addons is-centered">
            <span class="button is-link is-inverted" v-if="c" @click="createModal">
                <b-icon pack="fa" icon="plus"></b-icon>
            </span>
            <span class="button is-info is-inverted" v-if="r">
                <b-icon pack="fa" icon="eye"></b-icon>
            </span>
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
                <h1 class="subtitle is-1">Course Details:</h1>
                <div class="columns">
                    <div class="column">
                        <b-field label="Title">
                            <b-input v-model.trim="data.title" placeholder="Title"></b-input>
                        </b-field>
                    </div>
                    <div class="column">
                        <b-field label="Add some tags">
                            <b-taginput v-model="data.tags" icon="label" placeholder="Add a tag"></b-taginput>
                        </b-field>
                    </div>
                </div>
                <b-field label="Description">
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
        props: {token: String, address: String, id: String, sectionid: String, c: Boolean, u: Boolean, d: Boolean, r: Boolean, parent: Object},
        data() {
            return {
                isModalActive: false,
                data: {
                    title: '',
                    paragraph: '',
                    tags: [],
                },
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
                    this.parent._self.getData();
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
                    this.parent._self.getData();      
                })
                .catch(err => console.log(err));
            },
            destroy() {
                const vm = this;
                window.axios.delete('/api/dashboard/sections/' + vm.sectionid, { headers: { 'Authorization': 'Bearer ' + vm.token } })
                .then(() => {
                    this.$toast.open('Course deleted!');
                    this.parent._self.getData();                   
                })
                .catch(err => console.log(err));
            }
        }
    }
</script>

<style lang="css" scoped></style>
