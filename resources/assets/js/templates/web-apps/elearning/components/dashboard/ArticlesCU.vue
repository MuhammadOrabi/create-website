<template>
	<section>
		<b-field label="Title">
            <b-input v-model.trim="title" placeholder="Title"></b-input>
        </b-field>
        <b-field label="Add some tags">
            <b-taginput v-model="tags" icon="label" placeholder="Add a tag"></b-taginput>
        </b-field>
		<button class="button is-primary is-rounded" @click="isMediaModalActive = true">Add Show Case Image</button>
		<section class="p-t-20 columns is-multiline is-centered">
            <div class="column is-three-quarters" v-if="img">
                <figure class="image is-2by1">
                    <img :src="img">
                </figure>
            </div>
        </section>
		<b-modal :active.sync="isMediaModalActive" >
            <media v-bind="mediaProps" :parent="parent"></media>
        </b-modal>
		<b-tabs position="is-centered" class="block">
			<b-tab-item label="Using Text Editor">
				<b-field label="Article Preview" class="p-l-25">
					<div v-html="editor"></div>
		        </b-field>
            	<b-field label="Article" class="p-l-25">
		            <froala :config="paragraphConfig" v-model="editor" ></froala>
		        </b-field>
            </b-tab-item>
            <b-tab-item label="Using Markdown">
            	<b-field label="Article Preview" class="p-l-25">
					<div v-html="paragraph"></div>
		        </b-field>
            	<b-field label="Article">
            		<div class="editor">
		            	<textarea class="markdown" autofocus v-model="markedown"></textarea>
            		</div>
		        </b-field>
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
  	name: 'ArticlesCU',
  	props: ['address', 'token', 'id'],
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
  		parent() {
  			return this;
  		},
  		paragraph() {
      		return marked(this.markedown, { sanitize: true });
  		},
  		valid() {
  			return this.paragraph || this.editor && this.tags.length && this.title.length;
  		}
  	},
  	methods: {
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
  			if (value === '1') {
  				paragraph = this.editor;
  			} else if (value === '2') {
  				paragraph = this.paragraph;
  			}
  			let data = {title: this.title, img: this.img, paragraph: paragraph, tags: this.tags};
  			window.axios.post('/api/dashboard/sections/' + this.id, data, { headers: { 'Authorization': 'Bearer ' + this.token } })
            .then(() => {
               this.$toast.open({
                    message: 'Created Successfully',
                    type: 'is-success'
                });
               window.location = `/dashboard/pages/${this.id}/${this.address}`;
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