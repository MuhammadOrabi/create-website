<template>
    <v-container>
        <v-snackbar :timeout="6000" top :color="context" v-model="snackbar" >
			{{ msg }}
			<v-btn dark flat @click="snackbar = false">Close</v-btn>
		</v-snackbar>
        <form>
            <div class="text-xs-center">
                <v-avatar size="125px">
                    <img class="img-circle elevation-7 mb-1" :src="avatar">
                </v-avatar>
                <h4><span style="font-weight:bold">{{name}}</span></h4>
                <v-dialog v-model="avatarDialog" max-width="75%">
					<media :address="address" :token="token" :parent="parent" type="avatar"></media>
				</v-dialog>
                <v-btn class="mt-2" @click="avatarDialog = true">
                    Avatar
                    <v-icon right>perm_media</v-icon>
                </v-btn>
                <v-text-field v-model="name" label="Name"></v-text-field>
                <v-text-field v-model="password" label="New Password"></v-text-field>
                <v-text-field v-model="passowrdConfirm" label="Confirm New Passowrd"></v-text-field>
                <v-btn @click="save" dark color="success">Save</v-btn> 
            </div>
        </form>
    </v-container>
</template>
<script>
    import _ from 'underscore';
    export default {
        name: 'Settings',
        props: ['address'],
        data() {
            return {
                snackbar: false,
                context: '',
                msg: '',
                avatar: 'http://via.placeholder.com/250x350',
                name: 'Admin',
                password: '',
                passowrdConfirm: '',
                avatarDialog: false,
            }
        },
        computed: {
            token() {
                return this.$store.getters.session(this.address).token;
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
                        console.log(res.data.user);
                        this.name = res.data.user.name;
                        let userAvatar = _.findWhere(res.data.user.extras, {type: 'avatar'});
                        this.avatar = userAvatar? userAvatar.content : 'http://via.placeholder.com/250x350';
                    }
                })
                .catch(err => console.log(err));
            },
            save() {
                const vm = this;
                let data = {name: this.name, avatar: this.avatar};
                if (this.password.trim()) {
                    if (this.password === this.passowrdConfirm) {
                        data.password = this.password;
                    }
                }
                window.axios.put('/api/user', data, { headers: { 'Authorization': 'Bearer ' + vm.token } })
                .then(res => {
                    console.log(res.data);
                })
                .catch(err => console.log(err));
            }
        }
    }
</script>
