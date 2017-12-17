<template>
	<div>
		<div :class="'alert alert-' + msg + ' alert-dismissible fade show float'" role="alert" v-if="msg">
			<strong class="m-5" style="text-transform: capitalize">{{ msg }}</strong> 
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<button class="btn btn-success" id="button" v-if="update" @click="save" >Save</button>
		<button class="btn btn-warning" id="button" v-else @click="update = true" >Update</button>
		<div class="container-fluid">
			<div class="row">
				<div class="push-1 col-md-8">
					<div class="card">
						<div class="card-header">Who we Are?</div>
						<div class="card-block">
							<froala class="p-4" v-if="update" :config="paragraphConfig" v-model="paragraph"></froala>
							<p class="card-text p-4" v-else v-html="paragraph"></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {

		name: 'About',
		props: ['token', 'id', 'address'],
		data () {
			return {
				update: false,
				paragraph: '',
				msg: false,
				paragraphConfig: {
					placeholderText: 'Paragraph!',
					charCounterCount: true,
					toolbarInline: true,
					charCounterMax: 6000,
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
		mounted() {
			this.getData();
		},
		methods: {
			save() {
				let data = [
					{id: this.id, paragraph: this.paragraph}
				];
				window.axios.put('/api/contents/' + this.address, data, { headers: { 'Authorization': 'Bearer ' + this.token } })
				.then(res => {
					this.update = false;
					this.msg = res.data;
					this.getData();
				}).catch(err => console.log(err));
			},
			getData() {
				window.axios.get('/api/sections/' + this.id + '/edit', { headers: { 'Authorization': 'Bearer ' + this.token } })
				.then(res => {

					let paragraph = res.data[0];
					this.paragraph = paragraph? paragraph.content: '';
				}).catch(err => console.log(err));
			}
		}
	};
</script>

<style lang="css" scoped>
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
	.card-header{
		background-color: #1a8c97;
		color: white;
	}
	
</style>
