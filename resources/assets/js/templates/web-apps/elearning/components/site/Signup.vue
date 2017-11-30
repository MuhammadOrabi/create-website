<template>
	<v-container>
		<v-alert error dismissible v-if="alert">Try again!</v-alert>
		<v-card class="grey lighten-4 elevation-4">
			<v-card-title class="headline">Sign Up</v-card-title>
			<v-card-text>
				<v-container fluid>
					<form>
					<v-layout row>
						<v-flex xs4>
							<v-subheader>Name</v-subheader>
						</v-flex>
						<v-flex xs8>
							<v-text-field name="name" label="Name" v-model="name" 
								v-validate="'required'" v-bind:rules="[errors.first('name') || true]">
							</v-text-field>	
						</v-flex>
					</v-layout>
					<v-layout row>
						<v-flex xs4>
							<v-subheader>Email</v-subheader>
						</v-flex>
						<v-flex xs8>
							<v-text-field name="email" label="Email" type="email" v-model="email" 
								v-validate="'required|email'" v-bind:rules="[errors.first('email') || true]">
							</v-text-field>
						</v-flex>
					</v-layout>
					<v-layout row>
						<v-flex xs4>
							<v-subheader>Password</v-subheader>
						</v-flex>
						<v-flex xs8>
							<v-text-field name="password" label="Password"
									hint="At least 8 characters" min="8" 
									:append-icon="e1 ? 'visibility' : 'visibility_off'"
									:append-icon-cb="() => {e1 = !e1;}"
									:type="e1 ? 'password' : 'text'" v-model="password"
									v-validate="'required|min:8'" v-bind:rules="[errors.first('password') || true]"
									></v-text-field>
						</v-flex>
					</v-layout>
					<v-layout row>
						<v-flex xs4>
							<v-subheader>Confirm Password</v-subheader>
						</v-flex>
						<v-flex xs8>
							<v-text-field name="passowrdConfirm" label="Confirm Password"
									hint="At least 8 characters" min="8" v-model="passowrdConfirm"
									:append-icon="e2 ? 'visibility' : 'visibility_off'"
									:append-icon-cb="() => {e2 = !e2;}"
									:type="e2 ? 'password' : 'text'"
									single-line v-validate="'confirmed:password'" v-bind:rules="[errors.first('passowrdConfirm') || true]"
									></v-text-field>
						</v-flex>
					</v-layout>
					<v-layout row>
						<v-flex class="text-xs-center">
							<v-btn round color="info" light :disabled="errors.any() || invalid" @click="register">Sign Up</v-btn>
						</v-flex>
					</v-layout>
					</form>
				</v-container>
			</v-card-text>
		</v-card>
	</v-container>
</template>

<script>
export default {

	name: 'Signup',
	props: ['address'],
	data () {
		return {
			e1: true,
			e2: true,
			password: '',
			name: '',
			email: '',
			passowrdConfirm: '',
			error: '',
			alert: false
		}
	},
	computed: {
		invalid() {
			if (this.password === '' || this.name === '' || this.email === '') {
				return true;
			}
			return false;
		}
	},
	methods: {
		register() {
			const vm = this;
			let data = {name: vm.name, email: vm.email, address: vm.address, password: vm.password, password_confirmation: vm.passowrdConfirm};
			window.axios.post('/api/user', data)
			.then(res => {
				if (res.data) {
					this.alert = true;
					this.password = ''; 
					this.passowrdConfirm = ''; 
					this.email = '';
				}
				let session = {address: vm.address, token: res.data.token, id: res.data.user.id, name: res.data.user.name};
				this.$store.commit('addSession', session);
				window.location = '/s/' + this.address + '/profile';
			})
			.catch(err => console.log(err));
		}
	}
}
</script>

<style lang="css" scoped>
</style>