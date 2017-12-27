<template>
    <div class="columns">
		<div class="column is-one-third is-offset-one-third">
			<div class="card">
				<div class="card-content">
					<h1 class="title">Log In</h1>
					<form @submit.prevent="login" role="form">
						<div class="field">
							<label for="email" class="label">Email Address</label>
							<p class="control">
								<input :class="`input ${errors.email ? 'is-danger' : ''}`" type="email" v-model="email"
									id="email" placeholder="name@example.com" required>
							</p>
							<p v-if="errors.email" v-text="errors.email[0]" class="help is-danger"></p>
						</div>
						<div class="field">
							<label for="password" class="label">Password</label>
							<p class="control">
								<input :class="`input ${errors.password ? 'is-danger' : ''}`" type="password" v-model="password"
									id="password" required>
							</p>
							<p v-if="errors.password" v-text="errors.password[0]" class="help is-danger"></p>
						</div>
						<button type="submit" class="button is-success is-outlined is-fullwidth m-t-30">Log In</button>
					</form>
				</div>	
			</div>
			<h5 class="has-text-centered m-t-20">
				<a href="" class="is-muted">Forget Your Password?</a>
			</h5>
		</div>	
	</div>
</template>

<script>
    export default {
        name: 'Login',
        props: ['address'],
        data() {
            return {
				email: '',
				password: '',
				errors: {}
            };
        },
        computed: {},
        mounted() {},
        methods: {
			login() {
				const vm = this;
				let data = {email: vm.email, password: vm.password, address: vm.address};
				window.axios.post('/api/user/site/login', data)
				.then(res => {
					if (res.status) {
						this.$toast.open({
							duration: 5000,
							message: res.data.msg,
							position: 'is-top',
							title: 'Oops!',
							type: 'is-danger'
						});
						this.errors = res.data.errors ? res.data.errors : {};
						this.password = '';
						return;
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

<style lang="css" scoped></style>
