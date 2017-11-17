<template>
	<div>
		<div :class="'alert alert-' + msg + ' alert-dismissible fade show float'" role="alert" v-if="msg">
		  	<strong class="m-5" style="text-transform: capitalize">{{ msg }}</strong> 
		  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    	<span aria-hidden="true">&times;</span>
		 	</button>
		</div>
		<button class="btn btn-success" id="button" @click="save" >Save</button>
		<div class="container-fluid">
			<div class="row">
				<div class="push-1 col-md-8">
					<div class="card">
			  			<div class="card-header">Who we Are?</div>
			  			<div class="card-block">
				  			<textarea class="form-control border-0" v-model="p" autofocus rows="8" 
									v-if="input || p == ''" @mouseleave="input = false"></textarea>
						    <p class="card-text p-4" v-else @mouseover="input = true">{{ p }}</p>
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
	  	props: ['token', 'id'],
	  	data () {
		    return {
		    	p: '',
		    	input: false,
		    	pid: 0,
		    	msg: false,
		    	succ: false
		    };
	  	},
	  	mounted() {
	  		this.getData();
	  	},
	  	methods: {
	  		save() {
	  			let token = 'Bearer ' +  this.token;
	  			let data = [
	  				{id: this.pid, content: this.p}
	  			];
	  			axios.put('/api/contents', data, { headers: { 'Authorization': token } })
				.then(res => {
					this.msg = res.data;
				}).catch(err => console.log(err));
	  		},
	  		getData() {
	  			axios.get('/api/sections/' + this.id + '/edit', { headers: { 'Authorization': 'Bearer ' + this.token } })
				.then(res => {
					let par = res.data[0];
					this.p = par.content || 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum obcaecati fugit tenetur officiis, expedita modi fugiat quo animi, minima eveniet sed commodi architecto maxime nobis velit ipsam libero, voluptate tempora!';
					this.pid = par.id;
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
