<template>
	<v-container  >
		<v-card class="blue-grey darken-2  mt-3" >
			<v-card-title class="headline">
				<span class="white--text">{{ heading }}</span>
			</v-card-title>
			<v-card-media :src="imgUrl" height="350px"></v-card-media>
			<v-card-text class="white--text">{{ paragraph }}</v-card-text>
		</v-card>
	</v-container>
</template>

<script>
import _ from 'underscore';
export default {

	name: 'homePage',
	props: ['id'],
	data () {
		return {
			heading: '',
			paragraph: '',
			imgUrl: '',
			first: false
		}
	},
	mounted() {
  		this.getData();
  	},
  	methods: {
  		getData() {
  			axios.get('/api/pages/' + this.id)
  			.then((res)=>{
  				console.log(res.data);
  				let section = res.data.page.sections[0];
  				if (section) {
  					let h = _.findWhere(section.contents, {type: 'heading'});
  					this.heading = h.content;
  					let img = _.findWhere(section.contents, {type: 'img'});
  					this.imgUrl = img.content;
  					let p = _.findWhere(section.contents, {type: 'paragraph'});
  					this.paragraph = p.content;
  				} else {
  					this.first = true;
  				}
  			})
  			.catch(err => console.log(err));
  		}
  	}
}
</script>

<style lang="css" scoped>
</style>