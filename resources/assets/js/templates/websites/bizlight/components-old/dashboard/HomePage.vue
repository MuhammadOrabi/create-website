<template>
	<section>
		<div :class="'alert alert-' + msg + ' alert-dismissible fade show float'" role="alert" v-if="msg.length">
			<strong class="m-5" style="text-transform: capitalize">{{ msg }}</strong> 
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<button v-if="updateCheck" class="btn btn-success" @click="save" >Save</button>
		<button v-else class="btn btn-warning" @click="update" >Update</button>
		<show-case ref="showcase" :token="token" :id="showcase" ></show-case>
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
			msg: '',
			updateCheck: false
		}
	},
	methods: {
		update() {
			this.updateCheck = true;
			this.$refs.showcase.update = true;
			this.$refs.sectionb.update = true;
			this.$refs.sectiona.update = true;
			this.$refs.sectionc.update = true;
		},
		save() {
			let showcase = this.$refs.showcase.save();
			let a = this.$refs.sectiona.save();
			let b = this.$refs.sectionb.save();
			let c = this.$refs.sectionc.save();
			if (a && b && c && showcase) {
				this.msg = 'success';
			}
			this.updateCheck = false;
			this.$refs.showcase.update = false;
			this.$refs.sectionb.update = false;
			this.$refs.sectiona.update = false;
			this.$refs.sectionc.update = false;
		}
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