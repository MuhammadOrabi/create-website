<template>
	<v-container >
		<v-layout justify-center v-if="items.length > 1">
	    	<v-flex xs10 class="pt-5">
	    		<v-text-field append-icon="search" label="Search" solo v-model="search" ></v-text-field>
	    	</v-flex>
    	</v-layout>
		<v-layout row justify-center wrap class="pt-3" v-for="item in items" :key="item.id">
		    <v-flex xs10 >
				<v-card>
        			<v-card-media :src="item.img" height="200px" ></v-card-media>
        			<v-card-title primary-title>
			          	<div>
				            <div class="headline">{{ item.title }}</div>
				            <span class="grey--text">{{ item.date }}</span>
			          	</div>
			        </v-card-title>
        			<v-card-actions>
			          	<v-btn flat  @click.native="item.show = !item.show">
			          		Read More
			            	<v-icon icon>{{ item.show ? 'keyboard_arrow_down' : 'keyboard_arrow_up' }}</v-icon>
			          	</v-btn>
			        </v-card-actions>
			        <v-slide-y-transition>
			          	<v-card-text v-show="item.show">{{ item.paragraph }}</v-card-text>
			        </v-slide-y-transition>
			    </v-card>
		    </v-flex>
		</v-layout>
	</v-container>
</template>

<script>
import _ from 'underscore';
import moment from 'moment';

export default {

  	name: 'News',
  	props: ['id'],
  	data () {
    	return {
    		items: [],
    		search: ''
    	}
  	},
  	mounted() {
  		this.getData();
  	},
  	methods: {
  		getData() {
  			axios.get('/api/pages/' + this.id)
  			.then((res)=>{
  				res.data.page.sections.forEach((section) => {
  					let h = _.findWhere(section.contents, {type: 'heading'});
  					let img = _.findWhere(section.contents, {type: 'img'});
  					let p = _.findWhere(section.contents, {type: 'paragraph'});
  					let date = moment(section.created_at).calendar();
  					this.items.push({id: section.id, img: img.content, paragraph: p.content, title: h.content, date: date, show: false});
  				});
  			})
  			.catch(err => console.log(err));
  		}	
  	}
}
</script>

<style lang="css" scoped>
</style>