<template>
	<section>
		<b-tabs type="is-toggle" expanded animated v-model="activeTab">
			<b-tab-item label="Categories" icon="fa fa-arrow-right">
				<div class="columns p-t-15">
					<div class="column" v-for="(tag, i) in tags" :key="tag.id">	
						<div class="card">
							<div class="card-image">
								<figure class="image is-50x50">
									<img :src="tag.img" :alt="tag.tag">
								</figure>
							</div>
							<div class="card-content level">
								<p class="subtitle is-5 is-capitalized level-left">{{ tag.tag }}</p>
								<button :dusk="tag.tag" class="button is-primary level-right" @click="chooseCat(i)">Next</button>
							</div>
						</div>
					</div>
				</div>
			</b-tab-item>
			<b-tab-item label="Templates" icon="fa fa-arrow-right" :disabled="!themes.length">
				<div class="columns p-t-15">
					<div class="column is-one-quarter" v-for="theme in themes" :key="theme.id">	
						<div class="card">
							<div class="card-image">
								<figure class="image is-50x50">
									<img class="click" :src="theme.imgs[0].url" :alt="theme.theme">
								</figure>
							</div>
							<div class="card-content level">
								<p class="subtitle is-4 is-capitalized level-left" >#{{ theme.id }}</p>
								<button :dusk="theme.name" class="button is-primary level-right" @click="chooseTheme(theme.id)">Next</button>
							</div>
						</div>
					</div>
				</div>
			</b-tab-item>
			<b-tab-item label="Address" icon="fa fa-arrow-right" :disabled="!id">
				<div class="columns">
					<div class="column">
						<h1 class="title">Let's give your site an address.</h1>
					</div>
				</div>
				<div class="columns">
					<div class="column"></div>
					<div class="column is-three-quarters">
						<b-field  label="Domain" :type="`is-${color}`" :message="feedback">
							<b-input dusk="address" type="text" v-model="address" placeholder="Domain" maxlength="30" warning></b-input>
						</b-field>
					</div>
					<div class="column">
						<button dusk="create-site" class="button is-success m-t-30" :disabled="color !== 'success'" @click="create">
							<span class="icon is-small" v-if="color === 'success'">
								<i class="fa fa-check"></i>
							</span>
							<span>Save</span>
						</button>
					</div>
				</div>
			</b-tab-item>
		</b-tabs>
	</section>
</template>

<script>

export default {
	name: 'SiteCreator',
	props: ['token'],
	data () {
		return {
			user: '',
			tags: [],
			themes: [],
			feedback: '',
			address: '',
			color: '',
			id: 0,
			disable: true,
			activeTab: 0
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
			this.activeTab = 1;
		},
		chooseTheme(i) {
			this.activeTab = 2;
			this.id = i;
		},
		name_check() {
			const vm = this;
			if (this.address.length <= 5) {
				this.feedback = 'The Sub-Domain must be more than 5 characters and small letters!'
				this.color = 'danger';
				return;
			}
			window.axios.get('/api/dashboard/sites/exists/' + vm.address, { headers: { 'Authorization': 'Bearer ' + vm.token } })
			.then((res) => {
				if (res.data === 'danger') {
					vm.feedback = 'This address is taken, try another one!';
					vm.color = res.data;
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
            console.log(site);
            
			window.axios.post('/api/dashboard/sites', site ,{ headers: { 'Authorization': 'Bearer ' + vm.token } })
			.then((res) => {
                console.log(res.data);
                if (res.data.pages) {
					window.location = '/dashboard/settings/' + this.address;
				}
			})
			.catch((err) => console.log(err));
		}
	}
};
</script>

<style lang="css" scoped>
	.click{
		cursor: pointer;
	}
</style>
