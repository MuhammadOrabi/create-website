<template>
	<v-container>
		<v-layout justify-center v-if="courses.length > 1">
			<v-flex xs10>
				
			</v-flex>
		</v-layout>
		<v-layout justify-center v-if="courses.length > 1">
			<v-flex xs10>
				<v-text-field append-icon="search" label="Search" solo ></v-text-field>
			</v-flex>
		</v-layout>
		<v-layout row justify-center wrap class="pt-3" v-if="courses.length > 0">
			<v-flex xs10 elevation-15>
				<v-list avatar three-line>
					<template v-for="course in courses" >
						<v-list-tile :key="course.id" :href="'/s/' + address + '/course/' + course.id">
							<v-list-tile-avatar>
								<img src="/img/logo.png">
							</v-list-tile-avatar>
							<v-list-tile-content>
								<v-list-tile-title >
									<span>{{ course.title }}</span>
									<code class="caption grey--text mr-2" v-for="(tag,i) in course.tags" :key="i">{{ tag.content }}</code>
								</v-list-tile-title>
								<v-list-tile-sub-title>{{ course.paragraph }}</v-list-tile-sub-title>
							</v-list-tile-content>
						</v-list-tile>
					</template>
				</v-list>
			</v-flex>
		</v-layout>
		<v-layout row justify-center wrap class="pt-3" v-else>
			<span class="caption">There are No Courses yet!</span>
		</v-layout>
	</v-container>
</template>

<script>
const _ = window._;

export default {

	name: 'Courses',
	props: ['address', 'id'],
	data () {
		return {
			courses: []
		}
	},
	mounted() {
		this.getData();
	},
	methods: {
		getData() {
			window.axios.get('/api/pages/' + this.id)
			.then((res) => {
				res.data.page.sections.forEach((section) => {
					let tags = _.where(section.extras, {type: 'tag'});
					let p = _.findWhere(section.extras, {type: 'paragraph'});
					let title =section.title;
					this.courses.push({id: section.id, title: title, paragraph: p.content, tags: tags});
				});
			})
			.catch(err => console.log(err));
		}	
	}
}
</script>

<style lang="css" scoped>
</style>