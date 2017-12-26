<template>
   <v-layout justify-center>
		<v-snackbar :timeout="6000" top :color="context" v-model="snackbar" >
			{{ msg }}
			<v-btn dark flat @click="snackbar = false">Close</v-btn>
		</v-snackbar>
		<v-btn dark small color="primary" :href="`/s/${address}/news`" v-if="r" target="_blank">
			<v-icon>visibility</v-icon>
		</v-btn>
		<v-btn dark small color="green" @click.stop="showUpdate" v-if="u">
			<v-icon>edit</v-icon>
		</v-btn>
		<v-btn dark small color="indigo" @click.stop="showCreate" v-if="c">
			<v-icon>add</v-icon>
		</v-btn>
		<v-btn dark small color="red" v-if="d" @click="del">
			<v-icon>delete</v-icon>
		</v-btn>
        <v-dialog v-model="dialog" persistent max-width="70%">
			<v-card>
				<v-card-title>
					<span class="headline" style="text-transform: capitalize">{{ operation }} News</span>
				</v-card-title>
				<v-card-text>
					<v-container grid-list-md>
						<form>
							<v-layout row wrap>
								<v-flex sm5>
									<v-text-field v-model="title.content" label="Title" :error-messages="errors.collect('title')"
											v-validate="'required'" data-vv-name="title" required ></v-text-field>
									<v-text-field v-model="paragraph.content" label="Paragraph" :error-messages="errors.collect('paragraph')"
											v-validate="'required'" data-vv-name="paragraph" required multi-line ></v-text-field>
								</v-flex>
								<v-flex offset-sm1 sm5>
                                    <v-dialog v-model="imgDialog" max-width="50%">
                                        <media :address="address" :token="token" :parent="parentCrud" type="form"></media>
                                    </v-dialog>
                                    <v-btn color="warning" dark right  class="mt-2" @click.stop="imgDialog = true">
										<v-icon>perm_media</v-icon>
									</v-btn>
                                    <img v-if="imgUrl" :src="imgUrl" alt="" width="300px" height="250px">
								</v-flex>
							</v-layout>
						</form>	
					</v-container>
					<small>*indicates required field</small>
				</v-card-text>
				<v-card-actions>
					<v-spacer></v-spacer>
					<v-btn color="blue darken-1" flat @click.native="dialog = false">Close</v-btn>
					<v-btn color="primary" v-if="operation == 'create'" :disabled="errors.any() || invalid" @click="create">Create</v-btn>
					<v-btn color="primary" v-if="operation == 'update'" :disabled="errors.any() || invalid" @click="update">Update</v-btn>
				</v-card-actions>
			</v-card>
		</v-dialog>
   </v-layout>
</template>

<script>
    const _ = window._;

    export default {
        name: 'CRUDNews',
        props: {token: String, address: String, id: String, newsid: String, c: Boolean, u: Boolean, d: Boolean, r: Boolean, parent: Object},
        data() {
            return {
                snackbar: false,
                context: '',
                msg: '',
                dialog: false,
                imgDialog: false,
                title: {},
                paragraph: {},
                img: {},
                imgUrl: '',
                operation: ''
            };
        },
        computed: {
            invalid() {
                return false;
            },
            parentCrud() {
                return this;
            }
        },
        mounted() {
            if (this.u || this.d) {
                this.getData();
            }
        },
        methods: {
            getData() {
                const vm = this;
                window.axios.get('/api/sections/' + this.newsid, { headers: { 'Authorization': 'Bearer ' + vm.token } })
                .then( res => {
                   this.title = _.findWhere(res.data.section.contents, {type: 'heading'});
                   this.paragraph = _.findWhere(res.data.section.contents, {type: 'paragraph'});
                   this.img = _.findWhere(res.data.section.contents, {type: 'img'});
                   this.imgUrl = this.img.content;
                })
                .catch(err => console.log(err));
            },
            showUpdate() {
                this.dialog = true;
                this.operation = 'update';
            },
            showCreate() {
                this.dialog = true;
                this.operation = 'create';
                this.paragraph = '';
                this.title = {};
                this.paragraph = {};
                this.img = {};
                this.imgUrl = {};
            },
            create() {
                const vm = this;
                let data = {title: vm.title.content, description: vm.paragraph.content, url: vm.imgUrl}
                window.axios.post('/api/sections/' + vm.id, data, { headers: { 'Authorization': 'Bearer ' + vm.token } })
                .then(res => {
                    this.title = {};
                    this.paragraph = {};
                    this.imgUrl = {}; 
                    this.img = {}; 
                    this.snackbar = true;
                    this.context = res.data ? 'success' : 'error';
                    this.msg = res.data ? 'Posted' : 'Try Again!';
                    this.dialog = false;
                    this.parent._self.getData();
                })
                .catch(err => console.log(err));
            },
            update() {
                const vm = this;
                let data = [ 
                    {id: vm.title.id, content: vm.title.content},
                    {id: vm.paragraph.id, content: vm.paragraph.content},
                    {id: vm.img.id, content: vm.imgUrl}
                ];
                window.axios.put('/api/contents', data, { headers: { 'Authorization': 'Bearer ' + vm.token } })
                .then(res => {
                    this.snackbar = true;
                    this.context = res.data;
                    this.msg = res.data;
                    this.dialog = false;
                    this.parent._self.getData();
                }).catch(err => console.log(err));
            },
            del() {
                const vm = this;
                window.axios.delete('/api/sections/' + vm.newsid, { headers: { 'Authorization': 'Bearer ' + vm.token } })
                .then(res => {
                    this.getData();
                    this.snackbar = true;
                    this.context = res.data;
                    this.msg = res.data;
                    this.dialog = false;
                    this.parent._self.getData();
                }).catch(err => console.log(err));
            }
        }
    }
</script>

<style lang="css" scoped>

</style>


