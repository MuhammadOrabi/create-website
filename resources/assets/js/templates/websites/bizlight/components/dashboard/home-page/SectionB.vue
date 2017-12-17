<template>
	<div>
		<div class="section-b">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-6">
						<br><br><br>
						<div id="accordion" role="tablist" aria-multiselectable="true">
							<div class="float-none">
								<a v-if="update" class="btn btn-link text-muted" @click="add">
									<i class="fa fa-plus" aria-hidden="true"></i>
								</a>
							</div>
							<div v-for="(d, index) in data" :key="index" v-if="d.heading != null">
								<div class="float-right text-danger" v-if="update">
									<a class="btn btn-link" @click="remove(index)"><i class="fa fa-minus" aria-hidden="true"></i></a>
								</div>
								<div class="card">
									<div class="card-header grish" role="tab" id="headingOne">
										<div class="p-3" v-if="update">
											<froala :config="headingConfig" v-model="data[index].heading"></froala>
										</div>
										<a v-else class="nav-link p-0 grish" data-toggle="collapse" data-parent="#accordion" 
											:href="'#collapse' + index" aria-expanded="true" aria-controls="collapseOne">
											<p class="mb-0"  v-html="d.heading" ></p>
										</a>
									</div>

									<div :id="'collapse' + index" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
										<div class="card-block">
											<div class="p-3" v-if="update">
												<froala :config="paragraphConfig" v-model="data[index].paragraph" ></froala>
											</div>
											<p v-else class="p-3" v-html="d.paragraph"></p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<img :src="imgsrc" class="show" width="250" height="350" alt="img" @click="toggleModal">
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade bd-example-modal-lg" id="imgModalB" tabindex="-1" role="dialog" aria-hidden="true">
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
import _ from 'underscore';

export default {

	name: 'SectionB',
	props: ['token', 'id', 'address'],
	data () {
		return {
			update: false,
			data: [],
			show: 2,
			imgsrc: 'https://dummyimage.com/600x400/000/ffffff.png&text=Click+Here!',
			imgid: 0,
			msg: '',
			modal: false,
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
				charCounterMax: 60,
				imageUpload: false,
				fileUpload: false,
				toolbarButtons: [
					'bold', 'italic', 'underline', 'strikeThrough', '|', 'fontFamily', 'fontSize', 'color', 'inlineStyle', 'paragraphStyle', '|', 'paragraphFormat', 'align', 'outdent', 'indent', '-', 'insertLink', '|', 'specialCharacters', 'selectAll', 'clearFormatting', '|', 'print', 'spellChecker', 'help', 'html', '|', 'undo', 'redo'
					],
				quickInsertButtons: [ ],
				toolbarVisibleWithoutSelection: true
			}
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
			window.axios.get('/api/sections/' + this.id + '/edit', { headers: { 'Authorization': 'Bearer ' + this.token } })
			.then(res => {
				if (res.data.length === 0) {
					return;
				}
				let data = _.groupBy(res.data, 'order');
				this.imgsrc = data[0][0].content;
				this.data = [];
				_.each(data, (items, key) => {
					let heading = _.findWhere(items, {type: 'heading'});
					let paragraph = _.findWhere(items, {type: 'paragraph'});
					if (heading && paragraph) {
						this.data.push({heading: heading.content, paragraph: paragraph.content, order: key});
					}
				});
			}).catch(err => console.log(err));
		},
		
		add() {
			this.data.push({heading: '', paragraph: '' });
		},
		remove(i) {
			this.data[i].heading = null;
			this.data = _.difference(this.data, _.where(this.data, {heading: null}));
		},
		save() {
			let data = _.difference(this.data, _.where(this.data, {heading: ''}), _.where(this.data, {paragraph: ''}))			
			return { id: this.id, section: 'sectionB', img: this.imgsrc, data: data };
		},
		toggleModal() {
			if (this.update) {
				window.$('#imgModalB').modal('toggle');
			}
		}
	}
};
</script>

<style lang="css" scoped>
	.section-b{
		background: #e6ebf1;
		padding: 30px 0;
	}
	.show {
		width: 100%;
		cursor: pointer;
	}
	.panel-heading h4{
		color: set-text-color(#f4f4f4);
	}
	.grish {
		background-color: #1A8C97;
		color: #FFFFFF;
	}
</style>
