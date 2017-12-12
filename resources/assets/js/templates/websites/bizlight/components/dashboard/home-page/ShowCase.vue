<template>
	<div class="showcase">
		<div class="container-fluid">
			<div class="form-group"  v-if="h.h == '' || inputh">
				<input type="text" v-model="h.h" class="form-control border-0" @mouseout="inputh = false">
				<hr>
			</div>
			<h1 v-else @mouseover="inputh = true">{{ h.h }}</h1>
			<div class="form-group" v-if="inputp || p.p == ''">
				<textarea class="form-control border-0" @mouseleave="inputp = !inputp" v-model="p.p" rows="8"></textarea>
			</div>
			<p class="lead" v-else @mouseenter="inputp = !inputp">{{ p.p }}</p>
			<a href="#" class="btn grish">Read More</a>
		</div>
	</div>
</template>

<script>
export default {

	name: 'ShowCase',
	props: ['token', 'id'],
	data () {
		return {
			p: { id: 0, p: null},
			h: {id: 0, h: null},
			inputh: false,
			inputp: false,
			msg: ''

		};
	},
	mounted() {
		this.getData();
	},
	methods: {
		save() {
			return [{id: this.h.id, content: this.h.h}, {id: this.p.id, content: this.p.p}];
		},
		getData() {
			window.axios.get('/api/sections/' + this.id + '/edit', { headers: { 'Authorization': 'Bearer ' + this.token } })
			.then(res => {
				this.h.h = res.data[0].content || 'Heading';
				this.h.id = res.data[0].id;
				this.p.p = res.data[1].content || 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.';
				this.p.id = res.data[1].id;
			}).catch(err => console.log(err));
		}
	}
}
</script>

<style lang="css" scoped>
	.showcase{
		background: url(/img/showcase.jpg) no-repeat 0 -100px;
		height: 600px;
		padding: 30px 0;
	}
	h1{font-size: 40px;}
	.container-fluid{
		background: #fff;
		opacity: 0.8;
		padding: 20px 30px 30px 30px;
		margin-left: 30px;
		margin-right: 40px;
	}
	.grish {
		background-color: #1A8C97;
		color: #FFFFFF;
	}
</style>