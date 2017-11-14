<template>
	<v-container>
		<v-alert error dismissible v-model="alert" >
			{{ msg }}
		</v-alert>
		<v-card class="grey lighten-4 elevation-4 mt-5">
			<v-card-title class="headline">Sign In</v-card-title>
			<v-card-text>
				<v-container fluid>
					<v-layout row>
							<v-flex xs4>
								<v-subheader>Email</v-subheader>
							</v-flex>
							<v-flex xs8>
							<v-text-field name="email" label="Email" type="email" v-model="email"
									v-validate="'required|email'" v-bind:rules="[errors.first('email') || true]"
									></v-text-field>
									<span v-if="customErrors" class="red--text">{{ customErrors.email ? customErrors.email[0] : '' }}</span>
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
									 v-validate="'required|min:6'" v-bind:rules="[errors.first('password') || true]"
									 ></v-text-field>
							<span v-if="customErrors" class="red--text">{{ customErrors.password ? customErrors.password[0]: ''}}</span>
						</v-flex>
					</v-layout>
					<v-layout row>
						<v-flex class="text-xs-center">
						<v-btn round color="info" light :disabled="errors.any() || invalid" @click="login">Sign In</v-btn>
					</v-flex>
					</v-layout>
				</v-container>
			</v-card-text>
		</v-card>
	</v-container>
</template>

<script>
export default {

	name: 'Signin',
	props: ['address'],
	data () {
		return {
			e1: true,
			password: '',
			email: '',
			alert: false,
			msg: null,
			customErrors: null
		}
	},
	computed: {
  		invalid() {
  			if (this.password === '' || this.email === '') {
  				return true;
	    	}
	    	return false;
  		}
  	},
  	methods: {
  		login() {
  			const vm = this;
  			let data = {email: vm.email, password: vm.password, address: vm.address};
  			axios.post('/api/user/login', data)
	      	.then(res => {
	      		if (res.data.status) {
	      			this.alert = true;
	      			this.msg = res.data.msg
	      			this.customErrors = res.data.errors;
	      			this.password = '';
	      			return;
	      		}
	      		let session = {address: vm.address, token: res.data.token, id: res.data.user.id};
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