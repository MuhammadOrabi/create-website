<template>
	<v-container>
		<v-layout justify-center v-if="courses.length > 1">
			<v-flex xs10>
				
			</v-flex>
		</v-layout>
		<v-layout justify-center>
			<v-flex xs10>
				<v-text-field append-icon="search" label="Search" solo v-model="key"></v-text-field>
			</v-flex>
		</v-layout>
		<v-layout row justify-center wrap class="pt-3" v-if="filtered.length > 0">
			<v-flex xs10 elevation-15>
				<v-list avatar three-line>
					<template v-for="course in filtered" >
						<v-list-tile :key="course.id" :href="'/s/' + address + '/course/' + course.id">
							<v-list-tile-avatar>
								<img src="/img/logo.png">
							</v-list-tile-avatar>
							<v-list-tile-content>
								<v-list-tile-title >
									<span>{{ course.title }}</span>
									<code class="caption grey--text mr-2" v-for="(tag,i) in course.tags" :key="i">{{ tag }}</code>
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
import * as JsSearch from 'js-search';
export default {

	name: 'Courses',
	props: ['address', 'id'],
	data () {
		return {
			courses: [],
			key: ''
		}
	},
	computed: {
		auth() {
			return this.$store.getters.session(this.address);
		},
		filtered() {
			if (this.key) {
				let search = new JsSearch.Search('id');
				search.addIndex('title');
				search.addDocuments(this.courses);
				search.addIndex('tags');
				return search.search(this.key);
			} else {
				return this.courses;
			}
		}
	},
	mounted() {
		this.getData();
		this.log();
	},
	methods: {
		getData() {
			window.axios.get('/api/pages/' + this.id)
			.then((res) => {
				res.data.page.sections.forEach((section) => {
					let tags = _.pluck(_.where(section.extras, {type: 'tag'}), 'content');
					let p = _.findWhere(section.extras, {type: 'paragraph'});
					let title = section.title;
					this.courses.push({id: section.id, title: title, paragraph: p.content, tags: tags});
				});
			})
			.catch(err => console.log(err));
		},
		log() {
			let data = {};
			if (this.auth) {
				data.user = this.auth.id;
			}
			data.address = this.address;
			data.type = 'courses';
			data.action = 'View Courses Page';
			window.axios.post('/api/logs', data)
			.then(res => {
				// console.log(res.data);
			})
			.catch(err => console.log(err));
		}
	}
}
</script>

<style lang="css" scoped>
</style>
