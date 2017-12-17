<template>
	<div>
		<div :class="'alert alert-' + msg + ' alert-dismissible fade show float'" role="alert" v-if="msg">
			<strong class="m-5" style="text-transform: capitalize">{{ msg }}</strong> 
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<button class="btn btn-success" v-if="update" @click="save" >Save</button>
		<button class="btn btn-warning" v-else @click="update = true" >Update</button>
		<div class="services container-fluid">
			<div class="row">
				<div class="push-1 col-md-8">
					<a v-if="update" class="btn btn-link text-muted" @click="add">
						<i class="fa fa-plus" aria-hidden="true"></i>
					</a>
					<div class="m-4" v-for="(d, index) in data" :key="index">
						<div class="float-right text-danger">
							<a class="btn btn-link" v-if="update" @click="remove(index)"><i class="fa fa-minus" aria-hidden="true"></i></a>
						</div>
						<div class="card m-4">
							<div class="card-block">
								<froala class="p-3" v-if="update" :config="headingConfig" v-model="data[index].heading"></froala>
								<h4 class="card-title p-3" v-else  v-html="d.heading" ></h4>
								<froala class="p-3" v-if="update" :config="paragraphConfig" v-model="data[index].paragraph" ></froala>
								<p class="card-text p-3" v-else v-html="d.paragraph"></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	const _ = window._;
	export default {

		name: 'Services',
		props: ['token', 'id', 'address'],
		data () {
			return {
				update: false,
				data: [],
				msg: false,
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
		mounted() {
			this.getData();
		},
		methods: {
			save() {
				let services = _.difference(this.data, _.where(this.data, {heading: ''}), _.where(this.data, {paragraph: ''}));
				let data = [{ id: this.id, data: services }];
				window.axios.put('/api/contents/' + this.address, data, { headers: { 'Authorization': 'Bearer ' + this.token } })
				.then(res => {
					this.update = false;
					this.getData();
					this.msg = res.data;
				}).catch(err => console.log(err));
			},
			getData() {
				window.axios.get('/api/sections/' + this.id + '/edit', { headers: { 'Authorization': 'Bearer ' + this.token } })
				.then(res => {
					if (res.data.length === 0) {
						return;
					}
					let data = _.groupBy(res.data, 'order');
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
			}
		}
	};
</script>

<style lang="css" scoped>
	.card{
		background-color: #f5f5f5;
	}
	button{
		position: fixed;
		bottom: 55px;
		right: 65px;
		/* left: 700px; */
		z-index: 1030;
		float:  right;
		border-radius: 100%;
	}
	.float {
		position: fixed;
		z-index: 1030;
		right: 34%;
		float:  right;
	}
	
</style>
