<template>
	<div class="section-c">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-6">
					<img :src="imgsrc" class="show" width="250" height="350" alt="img" @click="toggleModal">
				</div>
				<div class="col-md-6">
					<blockquote class="blockquote">
						<froala v-if="update" :config="paragraphConfig" v-model="paragraph"></froala>
						<p class="mb-0" v-else v-html="paragraph"></p>
					</blockquote>
				</div>
			</div>
		</div>
		<div class="modal fade bd-example-modal-lg" id="imgModalC" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Media</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<media :address="address" :token="token" :parent="parent" type="one"></media>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	const _ = window._;
	export default {

		name: 'SectionC',
		props: ['token', 'id', 'address'],
		data () {
			return {
				update: false,
				paragraph: null,
				imgsrc: 'https://dummyimage.com/600x400/000/ffffff.png&text=Click+Here!',
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
			};
		},
		computed: {
			parent() {
				return this;
			}
		},
		mounted() {
			this.getData();
		},
		methods: {
			getData() {
				window.axios.get('/api/dashboard/sections/' + this.id, { headers: { 'Authorization': 'Bearer ' + this.token } })
				.then(res => {
					if (res.data.length === 0) {
						return;
					}
					let img = _.findWhere(res.data, {type: 'img'});
					let paragraph = _.findWhere(res.data, {type: 'paragraph'});
					this.imgsrc = img.content;
					this.paragraph = paragraph.content;
				}).catch(err => console.log(err));
			},
			save() {
				let data = {img: this.imgsrc, paragraph: this.paragraph};
				window.axios.put('/api/dashboard/sections/' + this.id, data, { headers: { 'Authorization': 'Bearer ' + this.token } })
				.then(res => {
					return true;
				}).catch(err => console.log(err));
			},
			toggleModal() {
				if (this.update) {
					window.$('#imgModalC').modal('toggle');
				}
			}
		}
	};
</script>

<style lang="css" scoped>
	.section-c{
		padding: 60px 0;
		background: #e6ebf1;
		color: #575757;
	}
	.show {
		width: 100%;
		cursor: pointer;
	}
	blockquote{
		padding-top: 45px;
		border-left: none;
		color: #575757;
		font-size: medium;
	}
</style>
