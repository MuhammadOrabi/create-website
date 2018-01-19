<template>
	<div class="showcase">
		<div class="container-fluid">
			<div class="form-group"  v-if="update">
				<froala :config="headingConfig" v-model="heading"></froala>				
				<hr>
			</div>
			<h1 v-else v-html="heading"></h1>
			<div class="form-group" v-if="update">
				<froala :config="paragraphConfig" v-model="paragraph"></froala>
			</div>
			<p class="lead" v-else v-html="paragraph" ></p>
			<button class="btn grish">Read More</button>
		</div>
	</div>
</template>

<script>
const _ = window._;
export default {

	name: 'ShowCase',
	props: ['token', 'id'],
	data () {
		return {
			update: false,
			paragraph: '',
			heading: '',
			msg: '',
			paragraphConfig: {
				placeholderText: 'Paragraph!',
				charCounterCount: true,
				toolbarInline: true,
				charCounterMax: 600,
				imageUpload: false,
				fileUpload: false,
				toolbarButtons: [
					'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', '|', 'fontFamily', 'fontSize', 'color', 'inlineStyle', 'paragraphStyle', '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', '-', 'insertLink', '|', 'specialCharacters', 'selectAll', 'clearFormatting', '|', 'print', 'spellChecker', 'help', 'html', '|', 'undo', 'redo'
					],
				quickInsertButtons: ['ul', 'ol'],
				toolbarVisibleWithoutSelection: true
			},
			headingConfig: {
				placeholderText: 'Heading!',
				charCounterCount: true,
				toolbarInline: true,
				charCounterMax: 100,
				imageUpload: false,
				fileUpload: false,
				toolbarButtons: [
					'bold', 'italic', 'underline', 'strikeThrough', '|', 'fontFamily', 'fontSize', 'color', 'inlineStyle', 'paragraphStyle', '|', 'paragraphFormat', 'align', 'outdent', 'indent', '-', 'insertLink', '|', 'specialCharacters', 'selectAll', 'clearFormatting', '|', 'print', 'spellChecker', 'help', 'html', '|', 'undo', 'redo'
					],
				quickInsertButtons: [],
				toolbarVisibleWithoutSelection: true
			}
		};
	},
	mounted() {
		this.getData();
	},
	methods: {
		save() {
			let data = {heading: this.heading, paragraph: this.paragraph};
			window.axios.put('/api/dashboard/sections/' + this.id, data, { headers: { 'Authorization': 'Bearer ' + this.token } })
			.then(res => {
				return true;
			}).catch(err => console.log(err));
		},
		getData() {
			window.axios.get('/api/dashboard/sections/' + this.id, { headers: { 'Authorization': 'Bearer ' + this.token } })
			.then(res => {
				if (res.data.length === 0) {
					return;
				}
				let heading = _.findWhere(res.data, {type: 'heading'});
				let paragraph = _.findWhere(res.data, {type: 'paragraph'});
				this.heading = heading.content;
				this.paragraph = paragraph.content;
			}).catch(err => console.log(err));
		}
	}
}
</script>

<style lang="css" scoped>
	.showcase{
		background: url(/img/showcase.jpg) no-repeat 0 -100px;
		height: 600px;
		padding: 30px 0;
	}
	h1{font-size: 40px;}
	.container-fluid{
		background: #fff;
		opacity: 0.8;
		padding: 20px 30px 30px 30px;
		margin-left: 30px;
		margin-right: 40px;
	}
	.grish {
		background-color: #1A8C97;
		color: #FFFFFF;
	}
</style>