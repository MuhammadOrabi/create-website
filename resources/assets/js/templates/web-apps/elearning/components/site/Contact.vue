<template>
	<v-container>
		<v-snackbar :timeout="6000" top :color="context" v-model="snackbar" >
			{{ msg }}
			<v-btn dark flat @click="snackbar = false">Close</v-btn>
		</v-snackbar>
		<v-card class="grey lighten-4 elevation-4">
			<v-card-title class="headline">Contact</v-card-title>
			<v-card-text>
				<v-container  fluid>
					<v-layout row >
						<v-flex xs4>
							<v-subheader>Name</v-subheader>
						</v-flex>
						<v-flex xs8 >
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
							<v-subheader>Message</v-subheader>
						</v-flex>
						<v-flex xs8>
							<v-text-field name="message" label="Message" v-model="message" multi-line
								v-validate="'required'" v-bind:rules="[errors.first('message') || true]">
						</v-text-field>
						</v-flex>
					</v-layout>
					<div class="text-xs-center">
						<v-btn round color="info" @click="send" :disabled="errors.any() || invalid" >Send</v-btn>
					</div>
				</v-container>
			</v-card-text>
		</v-card>
	</v-container>
</template>

<script>
export default {

	name: 'Contact',
	props: ['id'],
	data () {
		return {
			name: '',
    		email: '',
    		message: '',
    		snackbar: false,
    		context: '',
    		msg: ''
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
  		send() {
  			let data = {name: this.name, email: this.email, message: this.message};
  			axios.post('/api/contact/' + this.id, data)
  			.then((res) => {
  				this.message = '';
  				this.email = '';
  				this.name = '';
  				this.snackbar = true;
				this.context = res.data ? 'success' : 'error';
				this.msg = res.data ? 'Message Sent Successfully' : 'Try Again Later!';
  			})
  			.catch(err => console.log(err));
  		}
  	}
}
</script>

<style lang="css" scoped>
</style>