<template>
    <section>
        <h1 class="subtitle is-1">Items Details:</h1>
        <b-field label="Title">
            <b-input v-model.trim="data.title" placeholder="Title"></b-input>
        </b-field>
        <b-field label="Description">
            <froala :config="paragraphConfig" v-model.trim="data.paragraph"></froala>
        </b-field>
        <button class="button is-primary" v-if="c" @click="create" :disabled="!validCreate">Create</button>
        <button class="button is-primary" v-if="u" @click="update" :disabled="!validUpdate">Update</button>
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
                })
                .catch(err => console.log(err));
        	},
        	create() {
        		const vm = this;
        		let data = {title: vm.data.title, paragraph: vm.data.paragraph};
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
        	update() {
        		const vm = this;
        		let data = {title: vm.data.title, paragraph: vm.data.paragraph};
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
