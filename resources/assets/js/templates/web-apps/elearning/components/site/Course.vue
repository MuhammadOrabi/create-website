<template>
	<v-container >
		<section class="grey darken-1">
			<v-container>
	         	<v-card class="transparent elevation-0 white--text">
	         		<v-card-title class="display-3">{{ course.title }}</v-card-title>
	         		<v-card-text>{{ course.paragraph }}</v-card-text>
	         		<br>
	         		<v-card-text>
         				<v-chip label class="mr-5" v-for="tag in course.tags" v-text="tag.content" :key="tag.id"></v-chip>
	         		</v-card-text>
	         	</v-card>
	        </v-container>
		</section>
		<section>
			<v-layout row>
				<v-flex sm6 offset-sm1 class="pt-3">
					<v-card class="transparent elevation-0" >
						<v-list three-line>
				          <template>
				            <v-list-tile avatar :href="'/s/' + address + '/lesson/' + i" v-for="i in 4" :key="i">
				              	<v-list-tile-avatar>
				                	<v-chip label>{{i}}</v-chip>
				              	</v-list-tile-avatar>
				              	<v-list-tile-content>
				                	<v-list-tile-sub-title>Lesson {{i}}</v-list-tile-sub-title>
				                	<v-list-tile-title v-if="i == 1">Adding Our First Controller</v-list-tile-title>
				                	<v-list-tile-title v-else>Installing Laravel and Composer</v-list-tile-title>
				              	</v-list-tile-content>
				            </v-list-tile>
				          </template>
				        </v-list>
					</v-card>
				</v-flex>
			</v-layout>
		</section>
	</v-container>
</template>

<script>
import _ from 'underscore';
export default {

  	name: 'Course',
  	props: ['address', 'id'],
  	data () {
    	return {
    		course: []
		}
  	},
  	mounted() {
  		this.getData();
  	},
  	methods: {
  		getData() {
  			axios.get('/api/sections/' + this.id)
  			.then((res) => {
  				let section = res.data.section;
				let tags = _.where(section.extras, {type: 'tag'});
				let p = _.findWhere(section.extras, {type: 'paragraph'});
				let title = section.title;
				this.course = {id: section.id, title: title, paragraph: p.content, tags: tags, lessons: section.content};
  			})
  			.catch(err => console.log(err));
  		}
  	}
}
</script>

<style lang="css" scoped>
</style>