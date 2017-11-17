<template>
	<v-container>
		<section>
			<v-container>
				<p class="headline text-md-center">Adding Our First Controller</p>
				<p class="subheading text-md-center">How to build a blog with Laravel</p><br>
				<v-layout row xs12>
					<iframe width="1500" height="480" src="//www.youtube.com/embed/Q8TXgCzxEnw?rel=0" frameborder="0" allowfullscreen></iframe>
				</v-layout>
				<v-divider></v-divider>
				<v-layout class="pt-5" row>
					<v-flex justify-left xs5 class="pt-4">
						<p class="body-1">
							Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
							quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
							consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
							cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
							proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
						</p>
						<v-btn>Download Files</v-btn>
						<v-btn flat class="cap" :href="'/s/' + address + '/forum/' + id" target="_blank">
							Stuck? Check out the course forum and post your question
							<v-icon>open_in_new</v-icon>
						</v-btn>
					</v-flex>
					<v-flex justify-right offset-xs1 xs6>
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
	        </v-container>
		</section>
	</v-container>
</template>

<script>
export default {

  	name: 'Lesson',
  	props: ['id', 'address'],
  	data () {
    	return {

    	}
  	}
}
</script>

<style lang="css" scoped>
</style>