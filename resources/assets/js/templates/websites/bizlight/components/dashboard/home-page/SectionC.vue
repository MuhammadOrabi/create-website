<template>
	<div class="section-c">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-6">
    				<img :src="imgsrc" class="show" width="250" height="350" alt="img" data-toggle="modal" data-target="#imgModalC">
				</div>
				<div class="col-md-6">
					<blockquote class="blockquote">
						<textarea class="form-control border-0" v-model="p" autofocus rows="8" 
									v-if="input || p == ''" @mouseleave="input = false"></textarea>
						<p class="mb-0" v-else @mouseover="input = true">{{ p }}</p>
					</blockquote>
				</div>
			</div>
		</div>
		<div v-if="imgs.length" class="modal fade bd-example-modal-lg" id="imgModalC" 
			tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" >
  			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="p-5">
						<div id="thumbs">
                        	<img v-for="img in imgs" :src="img.url" @click="imgsrc = img.url" class="m-1 img-thumbnail"
                        		 width="180" height="180" data-dismiss="modal">
			            </div>
					</div>
			    </div>
  			</div>
		</div>
	</div>
</template>

<script>
	export default {

	  	name: 'SectionC',
	  	props: ['token', 'id'],
	  	data () {
		    return {
		    	input: false,
		    	p: null,
		    	pid: 0,
		    	imgs: [],
    			imgsrc: '',
    			imgid: 0,
    			msg: ''
		    };
	  	},
	  	mounted() {
	  		this.getData();
	  		this.imgs = this.$parent.$data.imgs;
	  	},
	  	methods: {
	  		getData() {
	  			axios.get('/api/section/' + this.id, { headers: { 'Authorization': 'Bearer ' + this.token } })
				.then(res => {
					let par = res.data[0];
					let img = res.data[1];
					this.imgsrc = img.content || 'http://via.placeholder.com/250x350';
					this.imgid = img.id;
					this.p = par.content || 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum obcaecati fugit tenetur officiis, expedita modi fugiat quo animi, minima eveniet sed commodi architecto maxime nobis velit ipsam libero, voluptate tempora!';
					this.pid = par.id;
				}).catch(err => console.log(err));
	  		},
	  		save() {
	  			return [
	  				{id: this.pid, content: this.p},
	  				{id: this.imgid, content: this.imgsrc}
	  			];
	  		}
	  	}
	};
</script>

<style lang="css" scoped>
	.section-c{
		padding: 60px 0;
		background: #e6ebf1;
		color: #575757;
	}
	.show {
		width: 100%;
		cursor: pointer;
	}
	blockquote{
		padding-top: 45px;
		border-left: none;
		color: #575757;
		font-size: medium;
	}
</style>
