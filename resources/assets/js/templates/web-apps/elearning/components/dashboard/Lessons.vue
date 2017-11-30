<template>
	<v-container>
		<v-snackbar :timeout="6000" top :color="context" v-model="snackbar" >
			{{ msg }}
			<v-btn dark flat @click="snackbar = false">Close</v-btn>
		</v-snackbar>
		<v-card>
			<v-card-title class="headline">
				Lessons
				<v-spacer></v-spacer>
				<v-text-field append-icon="search" label="Search" single-line hide-details v-model="search" ></v-text-field>
			</v-card-title>
			<v-data-table :headers="headers" :items="lessons" :search="search" class="elevation-1">
				<template slot="items" slot-scope="props">
					<tr @click="props.expanded = !props.expanded">
						<td class="text-xs-">{{ props.item.title }}</td>
						<td class="text-xs-">
							<v-btn dark small color="primary" :href="props.item.video" target="_blank">
								<v-icon>ondemand_video</v-icon>
							</v-btn>
						</td>
						<td>
							<crud-lessons r u d :parent="parent" :token="token" :address="address" 
								:id="id" :contentid="props.item.id + ''"></crud-lessons>
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
				<crud-lessons :parent="parent" c :token="token" :address="address" :id="id" ></crud-lessons>
			</div>
		</v-card>
	</v-container>
</template>

<script>
import _ from 'underscore';

export default {

	name: 'Lessons',
	props: ['token', 'address', 'id'],
	data () {
		return {
			search: '',
			selected: [],
			pagination: {},
			headers: [
				{ text: 'Title', align: 'left', value: 'title' },
				{ text: 'Video', align: 'left', value: 'video' },
			],
			lessons: [],
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
			window.axios.get('/api/sections/' + this.id)
			.then((res) => {
				this.lessons = [];
				let contents = res.data.section.contents; 
					contents.forEach((content) => {
						if (content.title) {
							let title = content.title;
							let video = _.findWhere(content.extras, {type: 'video'});
							this.lessons.push({id: content.id, title: title, paragraph: content.content, video: video.content});
						}
					});
			})
			.catch(err => console.log(err));
		},
			
	}
}
</script>

<style lang="css" scoped>
</style>