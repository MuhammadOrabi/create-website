<template>
	<v-app>
		<v-snackbar :timeout="6000" top :color="context" v-model="snackbar" >
			{{ msg }}
			<v-btn dark flat @click="snackbar = false">Close</v-btn>
		</v-snackbar>
		<v-container>
			<v-card>
			<v-dialog v-model="avatarDialog" max-width="75%">
				<media :address="address" :token="token" :parent="parent" type="avatar"></media>
			</v-dialog>
			<v-layout row wrap align-center>
	            <v-flex xs12 md4>
                	<v-card-text v-if="update">
	                	<v-btn icon class="mt-2" @click.stop="avatarDialog = true">
							<v-icon>perm_media</v-icon>
						</v-btn>
                		<v-text-field v-if="update" v-model="name" label="Name"></v-text-field>
                		<v-text-field v-if="update" v-model="title" label="Title"></v-text-field>
	                	<v-text-field v-model="twitter" label="Twitter"></v-text-field>
	                	<v-text-field v-model="facebook" label="Facebook"></v-text-field>
	                	<v-text-field v-model="github" label="Github"></v-text-field>
                	</v-card-text>
	              	<div v-else class="text-xs-center">
		                <v-avatar size="125px">
		                  	<img class="img-circle elevation-7 mb-1" :src="avatar">
		                </v-avatar>
	                	<h4><span style="font-weight:bold">{{name}}</span></h4>
	                	<h5 class="text-xs-center">{{title}}</h5>
		                <v-layout justify-space-between>
		                  	<v-btn icon class="blue--text text--darken-4">
		                      	<v-icon medium>fa-twitter</v-icon>
		                    </v-btn>
		                    <v-btn icon class="blue--text text--darken-4">
		                      	<v-icon medium>fa-github</v-icon>
		                    </v-btn>
		                  	<v-btn icon class="blue--text text--darken-4">
		                  		<v-icon medium>fa-facebook</v-icon>
		                	</v-btn>
		                </v-layout>
	              	</div>
	            </v-flex>
	            <v-flex xs12 md5 offset-md2>
					<v-card class="my-3" hover>
						<v-card-media class="white--text"  :src="imgUrl" height="170px" >
							<v-btn icon v-if="update" color="error" dark fab small right absolute class="mt-2" @click.stop="imgDialog = true">
								<v-icon>perm_media</v-icon>
							</v-btn>
							<v-container fill-height fluid>
		                      	<v-layout fill-height>
			                        <v-flex xs12 align-end flexbox>
			                        	<v-text-field focus v-if="update" v-model="heading" label="Heading"></v-text-field>
			                          	<span class="headline">{{ heading }}</span>
			                        </v-flex>
		                      	</v-layout>
		                    </v-container>
						</v-card-media>
						<v-dialog v-model="imgDialog" max-width="75%">
							<media :address="address" :token="token" :parent="parent" type="form"></media>
						</v-dialog>
						<v-flex class="ma-3" v-if="update" >
							<v-text-field label="Paragraph" v-model="paragraph" multi-line></v-text-field>
						</v-flex>
						<v-card-text v-else>{{ paragraph }}</v-card-text>
					</v-card>
				</v-flex>
			</v-layout>
			<v-card-actions>
				<v-btn color="pink" fab dark absolute top left  v-if="update" @click="save">
					<v-icon>save</v-icon>
				</v-btn>
				<v-btn color="pink" fab dark absolute top left  v-else @click="update = !update">
					<v-icon>edit</v-icon>
				</v-btn>
			</v-card-actions>
			</v-card>
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
			fab: false,
			name: '',
			nameId: null,
			title: '',
			titleId: null,
			avatar: 'http://via.placeholder.com/250x350',
			avatarId: null,
			twitter: '',
			twitterId: null,
			facebook: '',
			facebookId: null,
			github: '',
			githubId: null,
			updateAvatar: false,
			avatarDialog: false
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
			axios.get('/api/pages/' + this.id, { headers: { 'Authorization': 'Bearer ' + vm.token } })
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
					let name = _.findWhere(section.contents, {type: 'name'});
					this.name = name.content;
					this.nameId = name.id;
					let avatar = _.findWhere(section.contents, {type: 'avatar'});
					this.avatar = avatar.content;
					this.avatarId = avatar.id;
					let title = _.findWhere(section.contents, {type: 'title'});
					this.title = title.content;
					this.titleId = title.id;
					let facebook = _.findWhere(section.contents, {type: 'facebook'});
					this.facebook = facebook.content;
					this.facebookId = facebook.id;
					let twitter = _.findWhere(section.contents, {type: 'twitter'});
					this.twitter = twitter.content;
					this.twitterId = twitter.id;
					let github = _.findWhere(section.contents, {type: 'github'});
					this.github = github.content;
					this.githubId = github.id;
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
				let data = {heading: vm.heading, paragraph: vm.paragraph, img: vm.imgUrl, 
							name: vm.name, title: vm.title, avatar: vm.avatar, twitter: vm.twitter, facebook: vm.facebook, github: vm.github}
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
					{id: vm.imgId, content: vm.imgUrl},
					{id: vm.nameId, content: vm.name},
					{id: vm.titleId, content: vm.title},
					{id: vm.avatarId, content: vm.avatar},
					{id: vm.facebookId, content: vm.facebook},
					{id: vm.twitterId, content: vm.twitter},
					{id: vm.githubId, content: vm.github},
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