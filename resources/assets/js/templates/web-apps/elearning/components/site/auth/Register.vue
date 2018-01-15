<template>
    <div class="columns">
		<div class="column is-one-third is-offset-one-third">
			<div class="card">
				<div class="card-content">
					<h1 class="title">Register</h1>
					<form role="form" @submit.prevent="register">
						<div class="field">
							<label for="name" class="label">Name</label>
							<p class="control">
								<input :class="`input ${errors.name ? 'is-danger' : ''}`" type="text"
									v-model="name" id="name" placeholder="Jone Doe" required>
							</p>
							<p v-if="errors.name" v-text="errors.name[0]" class="help is-danger"></p>
						</div>
						<div class="field">
							<label for="email" class="label">Email Address</label>
							<p class="control">
								<input :class="`input ${errors.email ? 'is-danger' : ''}`" type="email" v-model="email"
									id="email" placeholder="name@example.com"  required>
							</p>
							<p v-if="errors.email" v-text="errors.email[0]" class="help is-danger"></p>
						</div>
						<div class="columns">
							<div class="column">
								<div class="field">
									<label for="password" class="label">Password</label>
									<p class="control">
										<input :class="`input ${errors.password ? 'is-danger' : ''}`" type="password" 
												v-model="password" id="password" required>
									</p>
                                    <p v-if="errors.password" v-text="errors.password[0]" class="help is-danger"></p>
								</div>
							</div>
							<div class="column">
								<div class="field">
									<label for="password_confirmation" class="label">Confirm Password</label>
									<p class="control">
										<input class="input" type="password" v-model="passowrdConfirm" id="password_confirmation" required>
									</p>
								</div>
							</div>
						</div>
						
						<button type="submit" class="button is-success is-outlined is-fullwidth m-t-30">Register</button>
					</form>
				</div>	
			</div> 
			<h5 class="has-text-centered m-t-20">
				<a :href="`/s/${address}/login`" class="is-muted">Already have an Account?</a>
			</h5>
		</div>	
	</div>
</template>

<script>
    export default {
        name: 'Register',
        props: ['address'],
        data() {
            return {
				name: '',
				email: '',
				password: '',
				passowrdConfirm: '',
				errors: {}
            };
        },
        computed: {},
        mounted() {},
        methods: {
			register() {
				const vm = this;
				let data = {name: vm.name, email: vm.email, address: vm.address, password: vm.password, password_confirmation: vm.passowrdConfirm};
				window.axios.post('/api/users/site/register', data)
				.then(res => {
					this.password = ''; 
					this.passowrdConfirm = ''; 
					if (res.data.errors) {
						this.errors = res.data.errors;
						return;
					}
					this.email = '';
					let session = {address: vm.address, token: res.data.token, id: res.data.user.id, name: res.data.user.name};
					this.$store.commit('addSession', session);
					this.log('User Signed Up', session.id);
					window.location = '/s/' + this.address + '/profile';
				})
				.catch(err => this.errors = err);	
			},
			log(action, id) {
				let data = {};
				data.user = id ? id : null;
				data.address = this.address;
				data.type = 'signup';
				data.action = action ? action : 'Access Sign Up Page';
				window.axios.post('/api/logs', data)
				.then(res => {
					console.log(res.data);
				})
				.catch(err => console.log(err));
			}
        }
    }
</script>

<style lang="css" scoped></style>
