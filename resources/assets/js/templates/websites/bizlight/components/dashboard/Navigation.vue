<template>
    <div>
        <div class="alert alert-success" role="alert" v-if="msg">
            {{ msg }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>    
        </div>
        <form @submit.prevent="save">
            <div class="row">
                <img :src="imgsrc" class="rounded mx-auto d-block show" width="200" height="200" alt="logo" @click="toggleModal">
            </div>
            <br>
            <div class="row">
                <div class="col input-group mb-3">
                    <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" placeholder="Facebook" v-model.trim="facebook">
                </div>
                <div class="col input-group mb-3">
                    <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" placeholder="Twitter" v-model.trim="twitter">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col input-group mb-3">
                    <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" placeholder="Google Plus" v-model.trim="google">
                </div>
                <div class="col input-group mb-3">
                    <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" placeholder="Linked In" v-model.trim="linkedin">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col text-center">
                    <button class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
        <div class="modal fade bd-example-modal-lg" id="imgModalNavigation" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Media</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<media :address="address" :token="token" :parent="parent" type="one"></media>
					</div>
				</div>
			</div>
		</div>
    </div>
</template>

<script>
    export default {
        name: 'Navigation',
        props: ['address', 'token', 'id'],
        data() {
            return {
				imgsrc: '',
                twitter: '',
                facebook: '',
                google: '',
                linkedin: '',
                msg: null
            };
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
            toggleModal() {
                window.$('#imgModalNavigation').modal('toggle');
            },
            getData() {
                 window.axios.get('/api/dashboard/constants/' + this.id, { headers: { 'Authorization': 'Bearer ' + this.token } })
                .then(res => {
                    console.log(res.data);
                    let contents = res.data.contents;
                    let logo = _.findWhere(contents, {type: 'logo'}).content;
                    this.imgsrc = logo ? logo : 'https://dummyimage.com/200x200/000/ffffff.png&text=Click+Here!';
                    this.facebook = _.findWhere(contents, {type: 'link', title: 'facebook-square'}).content;
                    this.twitter = _.findWhere(contents, {type: 'link', title: 'twitter'}).content;
                    this.google = _.findWhere(contents, {type: 'link', title: 'google-plus-g'}).content;
                    this.linkedin = _.findWhere(contents, {type: 'link', title: 'linkedin-in'}).content;

                }).catch(err => console.log(err));
            },
            save() {
                let data = {logo: this.imgsrc};
                data.facebook = this.facebook ? this.facebook : null;
                data.twitter = this.twitter ? this.twitter : null;
                data.google = this.google ? this.google : null;
                data.linkedin = this.linkedin ? this.linkedin : null;
                window.axios.put('/api/dashboard/constants/' + this.id, data, { headers: { 'Authorization': 'Bearer ' + this.token } })
				.then(res => {
					this.getData();
                    this.msg = 'success';
				}).catch(err => console.log(err));
            }
        }
    }
</script>

<style lang="css" scoped>
    .show {
        cursor: pointer;
    }
</style>
