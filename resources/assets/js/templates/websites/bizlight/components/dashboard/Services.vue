<template>
	<div>
		<div :class="'alert alert-' + msg + ' alert-dismissible fade show float'" role="alert" v-if="msg.length">
		  	<strong class="m-5" style="text-transform: capitalize">{{ msg }}</strong> 
		  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    	<span aria-hidden="true">&times;</span>
		 	</button>
		</div>
		<button class="btn btn-success" @click="save" >Save</button>
		<div class="services container-fluid">
			<div class="row">
				<div class="push-1 col-md-8">
					<a v-if="check()" class="btn btn-link text-muted" @click="add">
						<i class="fa fa-plus" aria-hidden="true"></i>
					</a>
					<div class="m-4" v-for="(d, index) in data" v-if="d.head != null">
						<div class="float-right text-danger">
							<a class="btn btn-link" @click="remove(index)"><i class="fa fa-minus" aria-hidden="true"></i></a>
						</div>
						<div class="card m-4">
						  	<div class="card-block">
						  		<input type="text" class="form-control border-0" v-if="data[index].head === '' || data[index].inputh"  
							  			v-model="data[index].head" @mouseleave="data[index].inputh = false;">
				  				<h4 class="card-title p-3" v-else  @mouseover="data[index].inputh = true;" >{{d.head}}</h4>
							    <textarea class="form-control border-0" v-model="data[index].data" autofocus rows="8"
  											v-if="data[index].data === '' || data[index].inputp" @mouseleave="data[index].inputp = false"></textarea>
								<p class="card-text p-3" v-else @mouseover="data[index].inputp = true">{{ d.data }}</p>
						  	</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import _ from 'underscore';
	export default {

	  	name: 'Services',
	  	props: ['token', 'id'],
	  	data () {
	    	return {
	    		data: [],
		    	msg: ''
	    	};
	  	},
	  	mounted() {
	  		this.getData();
	  	},
	  	methods: {
	  		save() {
	  			let token = 'Bearer ' +  this.token;
	  			let data = [
	  				{id: this.data[0].hid, content: this.data[0].head}, {id: this.data[0].pid, content: this.data[0].data},
	  				{id: this.data[1].hid, content: this.data[1].head}, {id: this.data[1].pid, content: this.data[1].data},
	  				{id: this.data[2].hid, content: this.data[2].head}, {id: this.data[2].pid, content: this.data[2].data}
	  			];
	  			axios.put('/api/contents', data, { headers: { 'Authorization': token } })
				.then(res => {
					this.msg = res.data;
				}).catch(err => console.log(err));
	  		},
	  		getData() {
	  			axios.get('/api/sections/' + this.id + '/edit', { headers: { 'Authorization': 'Bearer ' + this.token } })
				.then(res => {
					let order1 = _.where(res.data, {order: 1});
					let order2 = _.where(res.data, {order: 2});
					let order3 = _.where(res.data, {order: 3});
					this.data.push({
						hid: order1[0].id, pid: order1[1].id,
						head: order1[0].content, data: order1[1].content, 
						inputh: false, inputp: false
					});
					this.data.push({
						hid: order2[0].id, pid: order2[1].id,
						head: order2[0].content, data: order2[1].content, 
						inputh: false, inputp: false
					});
					this.data.push({
						hid: order3[0].id, pid: order3[1].id,
						head: order3[0].content, data: order3[1].content, 
						inputh: false, inputp: false
					});	
				}).catch(err => console.log(err));
	  		},
	  		check() {
  				return _.where(this.data, {head: null}).length !== 0;
  			},
  			add() {
	  			let avail = _.where(this.data, {head: null});
	  			avail[0].head = 'Head';
	  			avail[0].data = 'Text....';
	  		},
	  		remove(i) {
	  			this.data[i].head = null;
	  			this.data[i].data = null;
	  		}
	  	}
	};
</script>

<style lang="css" scoped>
	.card{
		background-color: #f5f5f5;
	}
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
	
</style>
