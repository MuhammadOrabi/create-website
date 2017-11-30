<template>
    <v-container>
        <v-snackbar :timeout="6000" top :color="context" v-model="snackbar" >
			{{ context }}
			<v-btn dark flat @click="snackbar = false">Close</v-btn>
		</v-snackbar>
        <v-layout justify-end>
            <v-btn dark color="teal" @click="dialog = true">Edit Profile</v-btn>
        </v-layout>
        <v-dialog v-model="dialog" persistent max-width="70%">
            <v-card>
                <v-card-title>
                    <span class="headline" style="text-transform: capitalize">Edit Profile</span>
                </v-card-title>
                <v-card-text>
                    <v-container grid-list-md>
                        <form>
                            <v-layout row wrap>
                                <v-flex sm5>
                                    <v-dialog v-model="avatarDialog" max-width="75%">
                                        <media :address="address" :token="token" :parent="parent" type="avatar"></media>
                                    </v-dialog>
                                    <v-btn class="mt-2" @click="avatarDialog = true">
                                        Avatar
                                        <v-icon right>perm_media</v-icon>
                                    </v-btn>
                                    <v-avatar size="75px" v-if="avatar">
                                        <img class="img-circle elevation-7 mb-1" :src="avatar">
                                    </v-avatar>
                                    <v-text-field v-model="name" label="Name" ></v-text-field>
                                    <v-text-field v-model="title" label="Title" ></v-text-field>
                                    <v-text-field v-model="password" label="New Password"></v-text-field>
                                    <v-text-field v-model="passowrdConfirm" label="Confirm New Passowrd"></v-text-field>
                                    <span v-if="msg" style="font-weight:bold; color:red">{{msg}}</span>
                                    <span></span>
                                </v-flex>
                                <v-flex offset-sm1 sm5>
                                    <v-text-field v-model="twitter" label="Twitter" ></v-text-field>
                                    <v-text-field v-model="facebook" label="Facebook" ></v-text-field>
                                    <v-text-field v-model="github" label="Github" ></v-text-field>
                                </v-flex>
                            </v-layout>
                        </form>
                    </v-container>
                    <small>*indicates required field</small>
                </v-card-text>
                <v-card-actions>
					<v-spacer></v-spacer>
					<v-btn color="blue darken-1" flat @click.native="dialog = false">Close</v-btn>
					<v-btn color="primary" @click="save">Save</v-btn>
				</v-card-actions>
            </v-card>
        </v-dialog>
        <div class="text-xs-center">
            <v-avatar size="125px" v-if="avatar">
                <img class="img-circle elevation-7 mb-1" :src="avatar">
            </v-avatar>
            <h4 v-if="name"><span style="font-weight:bold">{{name}}</span></h4>
            <h5 v-if="title" class="text-xs-center">{{title}}</h5>
            <v-layout justify-center>
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
    </v-container>
</template>

<script>
    const _ = window._;
    export default {
        name: 'Profile',
        props: ['address'],
        data() {
            return {
                snackbar: false,
                context: '',
                msg: '',
                dialog: false,
                avatarDialog: false,
                name: '',
                password: '',
                passowrdConfirm: '',
                avatar: '/img/logo.png',
                title: 'Web Developer',
                twitter: '',
                github: 'https://github.com/',
                facebook: 'https://facebook.com/'
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
                        this.twitter = twitter? twitter.content: 'https://twitter.com/';
                        let facebook = _.findWhere(res.data.user.extras, {type: 'facebook'});
                        this.facebook = facebook? facebook.content: 'https://facebook.com/';                        
                        let github = _.findWhere(res.data.user.extras, {type: 'github'});
                        this.github = github? github.content: 'https://github.com/'; 
                    }
                })
                .catch(err => console.log(err));
            },
            save() {
                const vm = this;
                let data = {
                    name: this.name, avatar: this.avatar, title: this.title, 
                    twitter: this.twitter, facebook: this.facebook, github: this.github
                };
                if (this.password.trim()) {
                    if (this.password === this.passowrdConfirm) {
                        data.password = this.password;
                    } else {
                        this.msg = 'Please Confirm Password!';
                        return;
                    }
                }
                window.axios.put('/api/user', data, { headers: { 'Authorization': 'Bearer ' + vm.token } })
                .then(res => {
                    if (res.data === 'success') {
                        this.dialog = false;
                        this.snackbar = true;
                        this.context = res.data;
                        this.password = '';
                        this.passowrdConfirm = '';
                        this.msg = '';
                    }
                })
                .catch(err => console.log(err));
            }
        }
    }
</script>

<style lang="css" scoped>

</style>


