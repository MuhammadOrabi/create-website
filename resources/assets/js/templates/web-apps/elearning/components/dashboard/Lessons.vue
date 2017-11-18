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
					<td class="text-xs-">{{ props.item.title }}</td>
					<td class="text-xs-">
						<v-btn dark small color="primary" :href="props.item.video" target="_blank">
				    		<v-icon>ondemand_video</v-icon>
				  		</v-btn>
					</td>
					<td class="text-xs-">
						<v-btn dark small color="primary" :href="props.item.files" target="_blank">
				    		<v-icon>insert_drive_file</v-icon>
				  		</v-btn>
					</td>
					<td class="">
						<crud-lessons r u d :token="token" :address="address" :id="id" :contentid="props.item.id + ''"></crud-lessons>
					</td>
				</template>
				<template slot="pageText" slot-scope="{ pageStart, pageStop }">
					From {{ pageStart }} to {{ pageStop }}
				</template>
			</v-data-table>
			<div class="text-xs-center pt-2">
				<crud-lessons c :token="token" :address="address" :id="id" ></crud-lessons>
			</div>
		</v-card>
	</v-container>
</template>

<script>
import _ from 'underscore';
import moment from 'moment';

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
				{ text: 'Files', align: 'left', value: 'files' },
			],
			lessons: [],
			context: '',
			snackbar: false,
			msg: ''
		}
  	},
  	mounted() {
  		this.getData();
  	},
  	methods: {
  		getData() {
  			const vm = this;
  			axios.get('/api/contents/' + this.id)
  			.then((res) => {
  				let contents = res.data.content.section.contents; 
  				contents.forEach((content) => {
  					let title = content.title;
  					let video = _.findWhere(content.extras, {type: 'video'});
  					let files = _.findWhere(content.extras, {type: 'files'});
  					this.lessons.push({id: content.id, title: title, paragraph: content.content, video: video.content, files: files.content});
  				});
  			})
  			.catch(err => console.log(err));
  		}	
  	}
}
</script>

<style lang="css" scoped>
</style>