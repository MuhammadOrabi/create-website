<template>
	<v-container class=" p-5">
		<v-stepper v-model="e1">
			<v-stepper-header>
				<v-stepper-step step="1" :complete="e1 > 1"> Step 1, Filter templates</v-stepper-step>
				<v-divider></v-divider>
				<v-stepper-step step="2" :complete="e1 > 2">Step 2, Pick a template</v-stepper-step>
				<v-divider></v-divider>
				<v-stepper-step step="3">Step 3, Pick an address</v-stepper-step>
			</v-stepper-header>
			<v-stepper-content step="1">
				<v-card  class="mb-5" >
					<v-card-title  primary-title>
						<div>
							<h4 class="headline">Let's get Started</h4>
							<p class="subheading">First up, what kind of website you are looking for?</p>
						</div>
					</v-card-title>
					<v-spacer></v-spacer>
					<v-container grid-list-md v-if="method === 'q'">
						<v-layout row wrap>
							<v-flex xs12>
								<v-text-field box multi-line label="Tell us, what are you building?"></v-text-field>
							</v-flex>
						</v-layout>
						<v-card-actions>
							<v-btn color="primary" @click="e1 = 2">Continue</v-btn>
						</v-card-actions>
					</v-container>
					<v-container grid-list-md v-if="method === 'c'">
						<v-layout row wrap justify-center>
							<v-flex xs12 sm3 v-for="(tag, i) in tags" :key="i">
								<v-card>
									<v-card-title>
										<span class="headline cap">{{ tag.tag }}</span>
									</v-card-title>
									<v-card-media :dusk="tags[i].tag" class="white--text click" height="200px" :src="tag.img" @click="chooseCat(i)" >
									</v-card-media>
								</v-card>
							</v-flex>
						</v-layout>
					</v-container>
				</v-card>
				<v-bottom-nav absolute :value="true" :active.sync="method" class="transparent">
					<v-btn flat color="teal" value="q">
						<span>By Question</span>
						<v-icon>question_answer</v-icon>
					</v-btn>
					<v-btn flat color="teal" value="c">
						<span>Categories</span>
						<v-icon>dashboard</v-icon>
					</v-btn>
				</v-bottom-nav>
			</v-stepper-content>
			<v-stepper-content step="2">
				<v-card class="mb-5" >
					<v-container grid-list-md>
						<v-layout row wrap justify-center v-if="themes[0]">
							<v-flex sm4 xs12 v-for="theme in themes" :key="theme.id">
								<v-card>
									<v-card-media class="white--text click" height="200px" @click="imgDialog = true"
										:src="theme.imgs[0]? theme.imgs[0].url : ''">
									</v-card-media>
									<v-dialog v-model="imgDialog" max-width="75%">
										<v-carousel dark class="hidden-md-and-down">
											<v-carousel-item v-for="img in theme.imgs" :src="img.url" :key="img.id"></v-carousel-item>
										</v-carousel>
									</v-dialog>
									<v-card-actions>
										<p class="title">{{ theme.name }}</p>
										<v-spacer></v-spacer>
										<v-btn :dusk="theme.name" color="success" flat @click="chooseTheme(theme.id)">
											Continue 
											<v-icon>arrow_right</v-icon>
										</v-btn>
									</v-card-actions>
								</v-card>
							</v-flex>
						</v-layout>
					</v-container>
				</v-card>
				<v-btn @click="e1 = 1" flat>
					<v-icon>arrow_left</v-icon>
					Back
				</v-btn>
			</v-stepper-content>
			<v-stepper-content step="3">
				<h3>Let's give your site an address.</h3>
				<p>Enter your site's name, or some key words that describe it - we'll use this to create your new site's address.</p>
				<v-text-field dusk="address" solo label="Enter an address..." prepend-icon="search" v-model="address" autofocus></v-text-field>
				<v-subheader :class="'caption ' + color + '--text'">{{ feedback }}</v-subheader>
				<v-layout >
					<v-btn @click="e1 = 2" flat>
						<v-icon>arrow_left</v-icon>
						Back
					</v-btn>
					<v-spacer></v-spacer>
					<v-btn color="success" dusk="create-site" @click="create" :disabled="disable">
						Continue
						<v-icon>arrow_right</v-icon>
					</v-btn>
				</v-layout>
			</v-stepper-content>
		</v-stepper>
	</v-container>	   
</template>

<script>

export default {
	name: 'SiteCreator',
	props: ['token'],
	data () {
		return {
			active: false,
			user: '',
			e1: 0,
			method: 'c',
			tags: [],
			themes: [],
			feedback: '',
			address: '',
			color: '',
			id: 0,
			disable: true,
			imgDialog: false
		};
	},
	mounted() {
		this.getData();
	},
	watch: {
		address(val) {
			this.address = val.toLowerCase().replace(/\s/g,'');
			this.name_check();
		}
	},
	methods: {
		getData() {
			window.axios.get('/themes')
			.then((res) => {
				this.tags = res.data;
			});
		},
		chooseCat(i) {
			this.themes = this.tags[i].themes;
			this.e1 = 2;
		},
		chooseTheme(i) {
			this.e1 = 3;
			this.id = i;
		},
		name_check() {
			const vm = this;
			if (this.address.length <= 5) {
				this.feedback = 'The address name must be more than 5 characters and small letters!'
				this.color = 'error';
				this.disable = true;
				return;
			}
			window.axios.get('/api/site/exists/' + vm.address, { headers: { 'Authorization': 'Bearer ' + vm.token } })
			.then((res) => {
				if (res.data === 'danger') {
					vm.feedback = 'This address is taken, try another one!';
					vm.color = 'error';
					vm.disable = true;
				} else {
					vm.feedback = 'Continue....';
					vm.color = 'success';
					this.disable = false;
				}
			})
			.catch((err) => console.log(err));
		},
		create() {
			var vm = this;
			let site = { theme: vm.id, address: vm.address };
			window.axios.post('/api/site', site ,{ headers: { 'Authorization': 'Bearer ' + vm.token } })
			.then((res) => {
				if (res.data.page) {
					window.location = '/dashboard/pages/' + res.data.page.id + '/edit';
				}
			})
			.catch((err) => console.log(err));
		}
	}
};
</script>

<style lang="css" scoped>
	.click{ cursor: pointer; }
</style>
