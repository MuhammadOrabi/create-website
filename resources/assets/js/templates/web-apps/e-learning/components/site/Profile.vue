<template>
  <v-container>
      <section class="teal darken-3">
			<v-container>
                <v-layout row >
                    <v-flex md2 class="pt-3 hidden-sm-and-down">
                        <v-avatar size="125px" v-if="avatar">
                            <img class="elevation-7 mb-1" :src="avatar">
                        </v-avatar>
                    </v-flex>
                    <v-flex class="pt-3 white--text">
                        <v-avatar size="125px" v-if="avatar" class="hidden-md-and-up">
                            <img class="elevation-7 mb-1" :src="avatar">
                        </v-avatar>
                        <h1 class="healine cap">{{ name }}</h1>
                        <h1 class="title cap">{{ title }}</h1>
                        <v-btn icon :href="facebook" target="_blank" ><v-icon class="white--text" medium>fa-facebook</v-icon></v-btn>
                        <v-btn icon :href="twitter" target="_blank" ><v-icon class="white--text" medium>fa-twitter</v-icon></v-btn>
                        <v-btn icon :href="github" target="_blank" ><v-icon class="white--text" medium>fa-github</v-icon></v-btn>
                    </v-flex>                    
                </v-layout>
                <EditProfile :address="address" :parentVue="parent"></EditProfile>
			</v-container>
		</section>
		<section>
			<v-layout row>
				<v-flex sm6 offset-sm1 class="pt-3">
					<v-card class="transparent elevation-0" >
						<v-list three-line>
							<template>
                                <v-subheader><b>Last Activities (Lessons)</b></v-subheader>
                                <v-list-tile avatar v-for="(lesson, i) in finalLessons" v-if="lesson"
                                    :href="`/s/${address}/lesson/${lesson.id}`" :key="lesson.id">
                                    <v-list-tile-avatar>
                                        <v-chip label>{{ i + 1 }}</v-chip>
                                    </v-list-tile-avatar>
                                    <v-list-tile-content>
                                        <v-list-tile-sub-title>{{ lesson.contentable.title }}</v-list-tile-sub-title>
                                        <v-list-tile-title>{{ lesson.title }}</v-list-tile-title>
                                    </v-list-tile-content>
                                </v-list-tile>
							</template>
						</v-list>
					</v-card>
				</v-flex>
                <v-flex sm5 class="pt-3">
                </v-flex>
			</v-layout>
		</section>
  </v-container>
</template>

<script>
    const _ = window._;
    import EditProfile from './EditProfile.vue';

    export default {
        name: 'Profile',
        components: {EditProfile},
        props: ['address'],
        data() {
            return {
                name: '',
                avatar: '',
                title: '',
                twitter: '',
                github: '',
                facebook: '',
                lessons: null,
            };
        },
        computed: {
            auth() {
                return this.$store.getters.session(this.address);
            },
            token() {
                return this.auth.token;
            },
            parent() {
                return this;
            },
            finalLessons() {
               let titles = _.uniq(_.pluck(this.lessons, 'title'));
               return titles.map(title => {
                   return _.findWhere(this.lessons, {title: title}); 
               });
            }
        },
        mounted() {
            this.getData();
        },
        methods: {
             getData() {
                const vm = this;
                window.axios.get('/api/user',  { headers: { 'Authorization': 'Bearer ' + vm.token } })
                .then(res => {
                    if (res.data.user) {
                        this.name = res.data.user.name;
                        this.title = res.data.user.title;
                        let userAvatar = _.findWhere(res.data.user.extras, {type: 'avatar'});
                        this.avatar = userAvatar? userAvatar.content : 'http://via.placeholder.com/250x350';
                        let twitter = _.findWhere(res.data.user.extras, {type: 'twitter'});
                        this.twitter = twitter? twitter.content: 'https://twitter.com';
                        let facebook = _.findWhere(res.data.user.extras, {type: 'facebook'});
                        this.facebook = facebook? facebook.content: 'https://facebook.com';                        
                        let github = _.findWhere(res.data.user.extras, {type: 'github'});
                        this.github = github? github.content: 'https://github.com'; 
                        let logs = _.where(res.data.user.logs, {type: 'lesson'});
                        let lessons = _.map(logs, (log) => {
                            return log.contents[0]? log.contents[0]: false;
                        });
                        this.lessons = _.compact(lessons);
                    }
                })
                .catch(err => console.log(err));
            },
        }
    }
</script>

<style lang="css" scoped>

</style>


