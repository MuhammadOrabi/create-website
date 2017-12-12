<template>
	<div>
		<div class="section-a">
			<div class="container-fluid">
				<div class="row">
					<a v-if="check" class="nav-link" @click="add()">
						<i class="fa fa-plus" aria-hidden="true"></i>
					</a>
					<div class="col-md-4 text-center" v-for="(d, index) in avail" :key="index">
						<div class="float-right text-danger">
							<a class="btn btn-link" @click="remove(index)"><i class="fa fa-minus" aria-hidden="true"></i></a>
						</div>
						<div class="row m-5">
							<img  @click="toggleModal(index)" :src="d.img" class="rounded-circle" width="150" height="150" alt="img" >
						</div>
						<input type="text" class="form-control border-0" v-if="avail[index].inputh || avail[index].h == ''" 
							v-model="avail[index].h" @mouseleave="avail[index].inputh = false;">
						<h3 v-else @mouseover="avail[index].inputh = true;">{{ d.h }}</h3>
						<textarea class="form-control border-0" v-model="avail[index].p" autofocus rows="8" 
									v-if="avail[index].inputp || avail[index].p == ''" @mouseleave="avail[index].inputp = false"></textarea>
						<p v-else @mouseover="avail[index].inputp = true">{{ d.p }}</p>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade bd-example-modal-lg" id="imgModalA" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Media</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<media :address="address" :token="token" :parent="parent" :index="index" type="array"></media>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import _ from 'underscore';
export default {

	name: 'SectionA',
	props: ['token', 'id', 'address'],
	data () {
		return {
			data: [],
			index: 0,
			msg: '',
			show: null
		}
	},
	mounted() {
		this.getData();
	},
	computed: {
		check() {
			return _.where(this.data, {h: null}).length !== 0;
		},
		avail () {
			let empty =  _.where(this.data, {h: null, p: null, img: null});
			return _.difference(this.data, empty);
		},
		parent() {
			return this;
		}
	},
	methods: {
			getData() {
				window.axios.get('/api/sections/' + this.id + '/edit', { headers: { 'Authorization': 'Bearer ' + this.token } })
				.then(res => {
					let order1 = _.where(res.data, {order: 1});
					let order2 = _.where(res.data, {order: 2});
					let order3 = _.where(res.data, {order: 3});
					this.data.push({
						hid: order1[0].id, pid: order1[1].id,
						h: order1[0].content, p: order1[1].content,
						img: order1[2].content, imgid: order1[2].id,
						inputh: false, inputp: false
					});
					this.data.push({
						hid: order2[0].id, pid: order2[1].id,
						h: order2[0].content, p: order2[1].content, 
						img: order2[2].content, imgid: order2[2].id,
						inputh: false, inputp: false
					});
					this.data.push({
						hid: order3[0].id, pid: order3[1].id,
						h: order3[0].content, p: order3[1].content, 
						img: order3[2].content, imgid: order3[2].id,
						inputh: false, inputp: false
					});	
				}).catch(err => console.log(err));
			},
			save() {
				return [
					{id: this.data[0].hid, content: this.data[0].h}, {id: this.data[0].pid, content: this.data[0].p},
					{id: this.data[0].imgid, content: this.data[0].img},
					{id: this.data[1].hid, content: this.data[1].h}, {id: this.data[1].pid, content: this.data[1].p},
					{id: this.data[1].imgid, content: this.data[1].img},
					{id: this.data[2].hid, content: this.data[2].h}, {id: this.data[2].pid, content: this.data[2].p},
					{id: this.data[2].imgid, content: this.data[2].img}
				];
				
			},
			add() {
				let empty = _.where(this.data, {h: null, p: null});
				empty[0].h = 'Some Heading';
				empty[0].p = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed aliquam ducimus voluptatum placeat nobis, ipsum rerum cum cumque illo harum fugiat quos laborum beatae soluta incidunt, aliquid animi quia.';
				empty[0].img = 'http://via.placeholder.com/150x150';
			},
			remove(i) {
				this.avail[i].h = null;
				this.avail[i].p = null;
				this.avail[i].img = null;
			},
			addimg(src) {
				this.avail[this.index].img = src;
			},
			toggleModal(index) {
				this.index = index;
				window.$('#imgModalA').modal('toggle');
			}
		}
	};
</script>

<style lang="css" scoped>
	.section-a{
		padding: 30px 0;
		text-align: center;
		background: #1A8C97;
		color: white;

	}
	a{ cursor: pointer; }
	img{ cursor: pointer; }
	p{ font-size: small; }
	
</style>
