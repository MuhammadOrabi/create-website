<template>
	<div>
		<div class="section-b">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-6">
						<br><br><br>
						<div id="accordion" role="tablist" aria-multiselectable="true">
							<div class="float-none">
								<a v-if="check()" class="btn btn-link text-muted" @click="add">
									<i class="fa fa-plus" aria-hidden="true"></i>
								</a>
							</div>
							<div v-for="(d, index) in data" :key="index" v-if="d.head != null">
								<div class="float-right text-danger">
									<a class="btn btn-link" @click="remove(index)"><i class="fa fa-minus" aria-hidden="true"></i></a>
								</div>
								<div class="card">
									<div class="card-header grish" role="tab" id="headingOne">
										<input type="text" class="form-control border-0" v-if="data[index].inputh || data[index].head == ''" 
											v-model="data[index].head" @mouseleave="data[index].inputh = false;">
										<h5 class="mb-0" v-else  @mouseover="data[index].inputh = true;" >{{d.head}}</h5>
										<a class="nav-link p-0 grish" data-toggle="collapse" data-parent="#accordion" :href="'#collapse' + index" 
											aria-expanded="true" aria-controls="collapseOne">
											<!-- None -->
										</a>
									</div>

									<div :id="'collapse' + index" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
										<div class="card-block">
											<textarea class="form-control border-0" v-model="data[index].data" autofocus rows="8"
												v-if="data[index].inputp || data[index].data == ''" @mouseleave="data[index].inputp = false"></textarea>
											<p v-else class="p-3" @mouseover="data[index].inputp = true">{{ d.data }}</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<img :src="imgsrc" class="show" width="250" height="350" alt="img" @click="toggleModal">
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade bd-example-modal-lg" id="imgModalB" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Media</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<media :address="address" :token="token" :parent="parent"></media>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import _ from 'underscore';

export default {

	name: 'SectionB',
	props: ['token', 'id', 'address'],
	data () {
		return {
			data: [],
			show: 2,
			imgsrc: '',
			imgid: 0,
			msg: '',
			modal: false,
		};
	},
	computed: {
		parent() {
			return this;
		}
	},
	mounted() {
		this.getData();
	},
	methods: {
		getData() {
			window.axios.get('/api/sections/' + this.id + '/edit', { headers: { 'Authorization': 'Bearer ' + this.token } })
			.then(res => {
				let order0 = _.where(res.data, {order: 0});
				let order1 = _.where(res.data, {order: 1});
				let order2 = _.where(res.data, {order: 2});
				let order3 = _.where(res.data, {order: 3});
				this.imgid = order0[0].id;
				this.imgsrc = order0[0].content || 'http://via.placeholder.com/250x350';
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
		
		add() {
			let avail = _.where(this.data, {head: null});
			avail[0].head = 'Head';
			avail[0].data = 'Text....';
		},
		remove(i) {
			this.data[i].head = null;
			this.data[i].data = null;
		},
		check() {
			return _.where(this.data, {head: null}).length !== 0;
		},
		save() {
			return [
				{id: this.data[0].hid, content: this.data[0].head}, {id: this.data[0].pid, content: this.data[0].data},
				{id: this.data[1].hid, content: this.data[1].head}, {id: this.data[1].pid, content: this.data[1].data},
				{id: this.data[2].hid, content: this.data[2].head}, {id: this.data[2].pid, content: this.data[2].data},
				{id: this.imgid, content: this.imgsrc}
			];
		},
		toggleModal() {
			window.$('#imgModalB').modal('toggle');
		}
	}
};
</script>

<style lang="css" scoped>
	.section-b{
		background: #e6ebf1;
		padding: 30px 0;
	}
	.show {
		width: 100%;
		cursor: pointer;
	}
	.panel-heading h4{
		color: set-text-color(#f4f4f4);
	}
	.grish {
		background-color: #1A8C97;
		color: #FFFFFF;
	}
</style>
