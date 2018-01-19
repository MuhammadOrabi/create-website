<template>
	<div>
		<div class="section-a">
			<div class="container-fluid">
				<div class="row">
					<a class="nav-link" v-if="update" @click="add()">
						<i class="fa fa-plus" aria-hidden="true"></i>
					</a>
				</div>
				<div class="row">
					<div class="col-md-4 text-center" v-for="(d, index) in data" :key="index">
						<div class="float-right text-danger" v-if="update">
							<a class="btn btn-link" @click="remove(index)"><i class="fa fa-minus" aria-hidden="true"></i></a>
						</div>
						<div class="row m-5">
							<img  @click="toggleModal(index)" :src="d.img" class="rounded-circle" width="150" height="150" alt="img" >
						</div>
						<div v-if="update">
							<froala :config="headingConfig" v-model="data[index].heading"></froala>
							<froala :config="paragraphConfig" v-model="data[index].paragraph" ></froala>
						</div>
						<div v-else>
							<h3 v-html="d.heading"></h3>
							<p v-html="d.paragraph"></p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade bd-example-modal-lg" id="imgModalA" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Media</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<media :address="address" :token="token" :parent="parent" :index="index" type="array"></media>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import _ from 'underscore';
export default {

	name: 'SectionA',
	props: ['token', 'id', 'address'],
	data () {
		return {
			update: false,
			data: [],
			index: 0,
			msg: '',
			show: null,
			paragraphConfig: {
				placeholderText: 'Paragraph!',
				charCounterCount: true,
				toolbarInline: true,
				charCounterMax: 150,
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
				charCounterMax: 60,
				imageUpload: false,
				fileUpload: false,
				toolbarButtons: [
						'fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript',  'fontFamily', 'fontSize', 'color', 
						'inlineStyle', 'paragraphStyle',  'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'insertLink','help', 
						'html',  'undo', 'redo'
					],
				quickInsertButtons: [],
				toolbarVisibleWithoutSelection: true
			}
		}
	},
	mounted() {
		this.getData();
	},
	computed: {
		parent() {
			return this;
		}
	},
	methods: {
		getData() {
			window.axios.get('/api/dashboard/sections/' + this.id , { headers: { 'Authorization': 'Bearer ' + this.token } })
			.then(res => {
				if (res.data.length === 0) {
					return;
				}
				let data = _.groupBy(res.data, 'order');
				this.data = [];
				_.each(data, (items, key) => {
					let heading = _.findWhere(items, {type: 'heading'});
					let paragraph = _.findWhere(items, {type: 'paragraph'});
					let img = _.findWhere(items, {type: 'img'});
					if (heading && paragraph) {
						this.data.push({heading: heading.content, paragraph: paragraph.content, img: img.content, order: key});
					}
				});
			}).catch(err => console.log(err));
		},
		save() {
			let data = _.difference(this.data, _.where(this.data, {heading: ''}), _.where(this.data, {paragraph: ''}));
			window.axios.put('/api/dashboard/sections/' + this.id, data, { headers: { 'Authorization': 'Bearer ' + this.token } })
			.then(res => {
				return true;
			}).catch(err => console.log(err));
		},
		add() {
			this.data.push({heading: '', paragraph: '', img: 'https://dummyimage.com/150x150/000/ffffff.png&text=Click+Here!'});
		},
		remove(i) {
			this.data[i].heading = null;
			this.data = _.difference(this.data, _.where(this.data, {heading: null}));
		},
		toggleModal(index) {
			if (this.update) {	
				this.index = index;
				window.$('#imgModalA').modal('toggle');
			}
		}
	}
};
</script>

<style lang="css" scoped>
	.section-a{
		padding: 30px 0;
		text-align: center;
		background: #1A8C97;
		color: white;

	}
	a{ cursor: pointer; }
	img{ cursor: pointer; }
	p{ font-size: small; }
	
</style>
