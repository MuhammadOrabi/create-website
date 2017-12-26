<template>
	<v-container>
		<v-snackbar :timeout="6000" top :color="context" v-model="snackbar" >
			{{ msg }}
			<v-btn dark flat @click="snackbar = false">Close</v-btn>
		</v-snackbar>
		<v-card>
			<v-card-title class="headline">
				Courses
				<v-spacer></v-spacer>
				<v-text-field append-icon="search" label="Search" single-line hide-details v-model="search" ></v-text-field>
			</v-card-title>
			<v-data-table :headers="headers" :items="courses" :search="search" class="elevation-1">
				<template slot="items" slot-scope="props">
					<tr @click="props.expanded = !props.expanded">
						<td class="text-xs-">{{ props.item.title }}</td>
						<td class="text-xs-">{{ props.item.tags.toLocaleString() }}</td>
						<td class="text-xs-">
							{{ props.item.lessons }}
							<v-btn dark small color="indigo" :href="`/dashboard/sections/${props.item.id}`">
								<v-icon>settings</v-icon>
							</v-btn>
						</td>
						<td class="">
							<crud-courses r u d :parent="parent" :token="token" :address="address" 
								:id="id" :sectionid="props.item.id + ''"></crud-courses>
						</td>
					</tr>
				</template>
				<template slot="expand" slot-scope="props">
					<v-card flat>
						<v-card-text>{{ props.item.paragraph }}</v-card-text>
					</v-card>
				</template>
				<template slot="pageText" slot-scope="{ pageStart, pageStop }">
					From {{ pageStart }} to {{ pageStop }}
				</template>
			</v-data-table>
			<div class="text-xs-center pt-2">
				<crud-courses c :parent="parent" :token="token" :address="address" :id="id" ></crud-courses>
			</div>
		</v-card>
	</v-container>
</template>

<script>
import _ from 'underscore';

export default {

	name: 'Courses',
	props: ['token', 'address', 'id'],
	data () {
		return {
			search: '',
			selected: [],
			pagination: {},
			headers: [
				{ text: 'Title', align: 'left', value: 'title' },
				{ text: 'Tags', align: 'left', value: 'tags' },
				{ text: 'Lessons', align: 'left', value: 'lessons' },
			],
			courses: [],
			context: '',
			snackbar: false,
			msg: ''
		}
	},
	computed: {
		parent() {
			return this;
		}
	},
	mounted() {
		this.getData();
	},
	methods: {
		getData() {
			window.axios.get('/api/pages/' + this.id)
			.then((res) => {
				this.courses = [];
				res.data.page.sections.forEach((section) => {
					let tags = _.pluck(_.where(section.extras, {type: 'tag'}), 'content');
					let p = _.findWhere(section.extras, {type: 'paragraph'});
					let title = section.title;
					let lessons = section.contents ? section.contents.length : 0;
					this.courses.push({id: section.id, title: title, paragraph: p.content, tags: tags, lessons: lessons});
				});
			})
			.catch(err => console.log(err));
		}	
	}
}
</script>

<style lang="css" scoped>
</style>