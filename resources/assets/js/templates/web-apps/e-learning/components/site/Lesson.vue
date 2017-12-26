<template>
	<v-container>
		<section>
			<v-container>
				<p class="headline text-md-center">{{ lesson.title }}</p>
				<p class="subheading text-md-center">{{ course.title }}</p><br>
				<v-layout row wrap>
					<iframe width="1500" height="480" :src="video.content" frameborder="0" allowfullscreen ></iframe>
				</v-layout>
				<v-divider></v-divider>
				<v-layout class="pt-5" row>
					<v-flex justify-left xs5 class="pt-4">
						<p class="body-1">{{ lesson.content }}</p>
						<v-btn flat class="cap" :href="`/s/${address}/forum/${course.id}`" target="_blank">
							Stuck? Check out the course forum and post your question
							<v-icon>open_in_new</v-icon>
						</v-btn>
					</v-flex>
					<v-flex justify-right offset-xs1 xs6>
						<v-card class="transparent elevation-0" >
							<v-list three-line>
								<template v-if="course">
								<v-list-tile avatar v-for="(lesson, i) in course.contents" :href="`/s/${address}/lesson/${lesson.id}`" :key="i">
									<v-list-tile-avatar>
										<v-chip label>{{i+1}}</v-chip>
									</v-list-tile-avatar>
									<v-list-tile-content>
										<v-list-tile-sub-title>Lesson {{i+1}}</v-list-tile-sub-title>
										<v-list-tile-title>{{ lesson.title }}</v-list-tile-title>
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
import _ from 'underscore';

export default {

	name: 'Lesson',
	props: ['id', 'address'],
	data () {
		return {
			course: [],
			lesson: [],
			video: '',
		}
	},
	computed: {
		auth() {
			return this.$store.getters.session(this.address);
		}
	},
	mounted() {
		this.getData();
	},
	methods: {
		getData() {
			window.axios.get(`/api/contents/${this.id}`)
			.then(res => {
				this.lesson = res.data.content;
				this.course = res.data.content.contentable;
				this.video = _.findWhere(this.lesson.extras, {type: 'video'});
				this.log();					
			})
			.catch(() => window.location = '/s/' + this.address + '/courses');
		},
		log() {
			let data = {};
			data.user = this.auth.id;
			data.content = this.lesson.id;
			data.section = this.course.id;
			data.type = 'lesson';
			data.action = 'Access Lesson Page';
			window.axios.post('/api/logs', data)
			.then(res => {
				console.log(res.data);
			})
			.catch(err => console.log(err));
		}
	}
}
</script>

<style lang="css" scoped>
</style>