<template>
	<section>
		<b-field label="Title">
            <b-input v-model.trim="title" placeholder="Title"></b-input>
        </b-field>
        <b-field label="Add some tags">
            <b-taginput v-model="tags" icon="label" placeholder="Add a tag"></b-taginput>
        </b-field>
		<button class="button is-primary is-rounded" @click="isMediaModalActive = true">Add Show Case Image</button>
        <b-modal :active.sync="isMediaModalActive" >
            <media v-bind="mediaProps" :imgUrl.sync="img" :active.sync="isMediaModalActive"></media>
        </b-modal>
		<section class="p-t-20 columns is-multiline is-centered">
            <div class="column is-three-quarters" v-if="img">
                <div class="notification">
                    <button class="delete" @click="img = null"></button>
                    <figure class="image is-2by1">
                        <img :src="img">
                    </figure>
                </div>
            </div>
        </section>
		<b-tabs position="is-centered" class="block" v-model="editors">
			<b-tab-item label="Using Text Editor">
                <b-tabs type="is-boxed">
                    <b-tab-item label="Article" icon="border-color">                    
                        <froala :config="paragraphConfig" v-model="editor" ></froala>
                        <small>*An Article Must Be More Than 50 Caracter!</small>
                    </b-tab-item>
                    <b-tab-item label="Preview" icon="eye">
                        <div v-html="editor"></div>
                    </b-tab-item>
                </b-tabs>
            </b-tab-item>
            <b-tab-item label="Using Markdown">
                <b-tabs type="is-boxed">
                    <b-tab-item label="Article" icon="border-color">                    
                        <textarea class="markdown" autofocus v-model="markedown"></textarea>
                        <small>*An Article Must Be More Than 50 Caracter!</small>
                    </b-tab-item>
                    <b-tab-item label="Preview" icon="eye">
                        <div v-html="paragraph"></div>
                    </b-tab-item>
                </b-tabs>
            </b-tab-item>
        </b-tabs>
        <div class="has-text-centered m-b-50">
        	<button class="button is-link is-rounded" @click="promptWhich" :disabled="!valid">Post</button>
        </div>
	</section>
</template>

<script>
import marked from 'marked';
export default {
  	name: 'Articles-CU',
  	props: {address: String, token: String, id: String, page: String, c: Boolean, u: Boolean},
  	data () {
    	return {
    		mediaProps: {
    			address: this.address,
    			token: this.token
    		},
    		isMediaModalActive: false,
    		img: null,
    		markedown: '',
    		editor: '',
    		tags: [],
    		title: '',
    		editors: 0,
    		paragraphConfig: {
				placeholderText: '',
				charCounterCount: true,
				// charCounterMax: 6000,
				imageUpload: false,
				fileUpload: false,
				// toolbarInline: true,
				heightMin: 200,
				// editorClass: 'p-l-25',
				toolbarButtons: [
					'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript',  'fontFamily', 'fontSize', 'color', 
					'inlineStyle', 'paragraphStyle',  'paragraphFormat', 'align', 'formatOL', 'outdent', 'indent', 'insertLink','help', 
					'html',  'undo', 'redo'
				],
				quickInsertButtons: ['ol'],
				toolbarVisibleWithoutSelection: true
			},
    	}
  	},
  	computed: {
  		paragraph() {
      		return marked(this.markedown, { sanitize: true });
  		},
  		valid() {
  			return this.paragraph.length > 50 || this.editor.length > 50 && this.tags.length && this.title.length;
  		}
  	},
  	mounted() {
  		if (this.u) {
  			this.getData();
  		}
  	},
  	methods: {
  		getData() {
  			window.axios.get('/api/dashboard/sections/' + this.id, { headers: { 'Authorization': 'Bearer ' + this.token } })
            .then(res => {
                let section = res.data;
                let paragraph = _.findWhere(section.contents, {type: 'paragraph'}).content;
                let type = section.type;
                let img = _.findWhere(section.contents, {type: 'img'});
                if (type === 'markedown') {
                	this.markedown = paragraph;
                	this.editors = 1;
                } else if (type === 'editor') {
                	this.editor = paragraph;
                	this.editors = 0;
                }
                this.img = img ? img.content : null;
                this.title = section.title;
                this.tags = _.pluck(_.where(section.extras, {type: 'tag'}), 'content');
            })
            .catch(err => console.log(err));
  		},
  		promptWhich() {
  			this.$dialog.prompt({
                message: `What's your Editor?<br><small><code>1</code> for Text Editor and <code>2</code> for Markdown</small>`,
                inputAttrs: {
                    type: 'number',
                    placeholder: 'Editor Or Markdown!',
                    value: '1',
                    max: 2,
                    min: 1,
                },
                onConfirm: (value) => this.save(value)
            });
  		},
  		save(value) {
  			let paragraph = null;
  			let type = null;
  			if (value === '1') {
  				paragraph = this.editor;
  				type = 'editor';
  			} else if (value === '2') {
  				paragraph = this.paragraph;
  				type = 'markedown';
  			}
  			let data = {title: this.title, img: this.img, paragraph: paragraph, tags: this.tags, type: type};
  			console.log(data);
  			if (this.c) {
  				this.create(data);
  			} else if (this.u) {
  				this.update(data);
  			}
  		},
  		create(data) {
  			window.axios.post('/api/dashboard/sections/' + this.page, data, { headers: { 'Authorization': 'Bearer ' + this.token } })
            .then(() => {
               this.$toast.open({
                    message: 'Created Successfully',
                    type: 'is-success'
                });
               window.location = `/dashboard/pages/${this.page}/${this.address}`;
            })
            .catch(err => console.log(err));
  		},
  		update(data) {
  			window.axios.put('/api/dashboard/sections/' + this.id, data, { headers: { 'Authorization': 'Bearer ' + this.token } })
            .then(() => {
               this.$toast.open({
                    message: 'Updted Successfully',
                    type: 'is-success'
                });
               window.location = `/dashboard/pages/${this.page}/${this.address}`;
            })
            .catch(err => console.log(err));
  		}
	}
}
</script>

<style lang="css" scoped>
	.markdown, .editor {
	  	display: inline-block;
	  	width: 100%;
	  	height: 500px;
	  	vertical-align: top;
	  	box-sizing: border-box;
	  	padding: 0 20px;
	}
	.markdown {
	  border: none;
	  resize: none;
	  outline: none;
	  background-color: #f6f6f6;
	  font-size: 14px;
	  font-family: 'Monaco', courier, monospace;
	  padding: 20px;
	}
</style>