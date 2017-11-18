<template>
	<v-container>
      	<v-layout row wrap align-center>
            <v-flex xs12 md4>
              	<div class="text-xs-center">
	                <v-avatar size="125px" v-if="avatar">
	                  	<img class="img-circle elevation-7 mb-1" :src="avatar">
	                </v-avatar>
                	<h4 v-if="name"><span style="font-weight:bold">{{name}}</span></h4>
                	<h5 v-if="title" class="text-xs-center">{{title}}</h5>
	                <v-layout justify-space-between>
	                  	<v-btn v-if="twitter" :href="twitter" target="_blank" icon class="blue--text text--darken-4">
	                      	<v-icon medium>fa-twitter</v-icon>
	                    </v-btn>
	                    <v-btn v-if="github" :href="github" target="_blank" icon class="blue--text text--darken-4">
	                      	<v-icon medium>fa-github</v-icon>
	                    </v-btn>
	                  	<v-btn v-if="facebook" :href="facebook" target="_blank" icon class="blue--text text--darken-4">
	                  		<v-icon medium>fa-facebook</v-icon>
	                	</v-btn>
	                </v-layout>
              	</div>
            </v-flex>
            <v-flex xs12 md5 offset-md2>
              	<div v-for="post in posts" :key="post.title">
	                <v-card class="my-3" hover>
	                  	<v-card-media class="white--text" height="170px" :src="post.imgUrl">
		                    <v-container fill-height fluid>
		                      	<v-layout fill-height>
			                        <v-flex xs12 align-end flexbox>
			                          	<span class="headline">{{ post.title }}</span>
			                        </v-flex>
		                      	</v-layout>
		                    </v-container>
                  		</v-card-media>
                  		<v-card-text>{{ post.content }}</v-card-text>
	                </v-card>
              	</div>
            </v-flex>
		</v-layout>
	</v-container>
</template>

<script>
import _ from 'underscore';
export default {
  	name: 'About',
  	props: ['id'],
  	data () {
    	return {
    		posts: [],
    		name: '',
    		title: '',
    		avatar: '',
    		twitter: '',
    		facebook: '',
    		github: '',
    	}
  	},
  	mounted() {
  		this.getData();
  	},
  	methods: {
  		getData() {
  			axios.get('/api/pages/' + this.id)
  			.then( res => {
  				let section = res.data.page.sections[0];
  				if (section) {
  					let h = _.findWhere(section.contents, {type: 'heading'});
  					let img = _.findWhere(section.contents, {type: 'img'});
  					let p = _.findWhere(section.contents, {type: 'paragraph'});
  					this.name = _.findWhere(section.contents, {type: 'name'}).content;
  					this.title = _.findWhere(section.contents, {type: 'title'}).content;
  					this.avatar = _.findWhere(section.contents, {type: 'avatar'}).content;
  					this.facebook = _.findWhere(section.contents, {type: 'facebook'}).content;
  					this.twitter = _.findWhere(section.contents, {type: 'twitter'}).content;
  					this.github = _.findWhere(section.contents, {type: 'github'}).content;
  					this.posts.push({title: h.content, content: p.content, imgUrl: img.content});
  				}
  			})
  			.catch(err => console.log(err));
  		}
  	}
}
</script>

<style lang="css" scoped>
</style>