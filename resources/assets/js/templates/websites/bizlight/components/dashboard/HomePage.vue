<template>
	<section>
		<div :class="'alert alert-' + msg + ' alert-dismissible fade show float'" role="alert" v-if="msg.length">
			<strong class="m-5" style="text-transform: capitalize">{{ msg }}</strong> 
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<button class="btn btn-success" @click="save" >Save</button>
		<show-case ref="showcase" :token="token" :id="showcase"></show-case>
		<section-b ref="sectionb" :token="token" :id="sectionb" :address="address"></section-b>
		<section-a ref="sectiona" :token="token" :id="sectiona" :address="address"></section-a>
		<section-c ref="sectionc" :token="token" :id="sectionc" :address="address"></section-c>
	</section>
</template>

<script>

import _ from 'underscore';

import ShowCase from './home-page/ShowCase.vue';
import SectionA from './home-page/SectionA.vue';
import SectionB from './home-page/SectionB.vue';
import SectionC from './home-page/SectionC.vue';

export default {

	name: 'HomePage',
	props: ['token', 'address', 'showcase', 'sectiona', 'sectionb', 'sectionc'],
	components: {SectionA, SectionB, SectionC, ShowCase},
	data () {
		return {
			imgs: [],
			msg: ''
		}
	},
	beforeMount() {
		this.getImgs();
	},
	methods: {
		save() {
			let data = _.union(
				this.$refs.showcase.save(), this.$refs.sectiona.save(), this.$refs.sectionb.save(), this.$refs.sectionc.save()
			);
			axios.put('/api/contents', data, { headers: { 'Authorization': 'Bearer ' + this.token } })
			.then(res => {
				this.msg = res.data;
			}).catch(err => console.log(err));
		},
		getImgs() {
  			axios.get('/api/imgs/' + this.address, { headers: { 'Authorization': 'Bearer ' + this.token } })
  			.then(res => {
  				this.imgs = res.data;
			}).catch(err => console.log(err));
  		},
	}

}
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
</style>