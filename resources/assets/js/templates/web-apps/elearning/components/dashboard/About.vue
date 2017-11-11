<template>
	<v-app>
		<v-snackbar :timeout="6000" top :color="context" v-model="snackbar" >
			{{ msg }}
			<v-btn dark flat @click="snackbar = false">Close</v-btn>
		</v-snackbar>
		<v-container grid-list-xl>
			<v-layout row wrap >
				<v-flex xs12>
					<v-card class="blue-grey darken-2 mt-3" >
						<v-card-title class="headline">
							<v-text-field focus dark v-if="update" v-model="heading" label="Heading"></v-text-field>
							<span v-else class="white--text">{{ heading }}</span>
						</v-card-title>
						<v-card-media :src="imgUrl" height="350px" >
							<v-btn icon v-if="update" color="error" dark fab small right absolute class="mt-2" @click.stop="imgDialog = true">
								<v-icon>edit</v-icon>
							</v-btn>
						</v-card-media>
						<v-dialog v-model="imgDialog" max-width="75%">
							<media :address="address" :token="token" :parent="parent" type="form"></media>
						</v-dialog>
							<v-flex class="ma-3" v-if="update" >
								<v-text-field label="Paragraph" dark v-model="paragraph" multi-line></v-text-field>
							</v-flex>
							<v-card-text v-else class="white--text">{{ paragraph }}</v-card-text>
						<v-card-actions>
							<v-btn color="pink" fab dark absolute top right  v-if="update" @click="save">
								<v-icon>save</v-icon>
							</v-btn>
							<v-btn color="pink" fab dark absolute top right  v-else @click="update = !update">
								<v-icon>edit</v-icon>
							</v-btn>
						</v-card-actions>
					</v-card>
				</v-flex>
			</v-layout>
		</v-container>
	</v-app>
</template>

<script>
import _ from 'underscore';

export default {
  	name: 'About',
  	props: ['address', 'token', 'id'],
  	data () {
    	return {
    		snackbar: false,
			context: '',
			msg: '',
			update: false,
			heading: '',
			paragraph: '',
			imgUrl: '',
			hId: null,
			pId: null,
			imgId: null,
			imgDialog: false,
			first: false,
			fab: false
    	}
  	},
  	mounted() {
		this.getData();
	},
	computed: {
		isValid() {
			return this.imgUrl !== '' && this.paragraph.trim() !== '' && this.heading.trim() !== '';
		},
		parent() {
			return this;
		}
	},
	methods: {
		getData() {
			const vm = this;
			axios.get('/api/sections/' + this.id, { headers: { 'Authorization': 'Bearer ' + vm.token } })
			.then((res)=>{
				let section = res.data.page.sections[0];
				if (section) {
					let h = _.findWhere(section.contents, {type: 'heading'});
					this.heading = h.content;
					this.hId = h.id;
					let img = _.findWhere(section.contents, {type: 'img'});
					this.imgUrl = img.content;
					this.imgId = img.id;
					let p = _.findWhere(section.contents, {type: 'paragraph'});
					this.paragraph = p.content;
					this.pId = p.id;
				} else {
					this.first = true;
				}
			})
			.catch(err => console.log(err));
		},
		save() {
			this.update = !this.update;
			const vm = this;
			if (this.first) {
				let data = {heading: vm.heading, paragraph: vm.paragraph, img: vm.imgUrl}
				axios.post('/api/sections/' + vm.id, data, { headers: { 'Authorization': 'Bearer ' + vm.token } })
				.then(res => {
					this.snackbar = true;
					this.context = res.data ? 'success' : 'error';
					this.msg = res.data ? 'Saved' : 'Try Again!';
					this.loading = false;
					this.getData();
				})
				.catch(err => console.log(err));
			} else {
				let data = [ 
					{id: vm.hId, content: vm.heading},
					{id: vm.pId, content: vm.paragraph},
					{id: vm.imgId, content: vm.imgUrl}
				];
				axios.put('/api/contents', data, { headers: { 'Authorization': 'Bearer ' + vm.token } })
				.then(res => {
					this.snackbar = true;
					this.context = res.data;
					this.msg = res.data;
				}).catch(err => console.log(err));
			}
		}
	}
}
</script>

<style lang="css" scoped>
</style>