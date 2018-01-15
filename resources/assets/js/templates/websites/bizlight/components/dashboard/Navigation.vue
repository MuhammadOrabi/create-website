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
                <div class="col">
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon3">https://facebook.com/</span>
                        <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" placeholder="UserName"
                             v-model.trim="facebook">
                    </div>
                </div>
                <div class="col">
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon3">https://twitter.com/</span>
                        <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" placeholder="UserName"
                             v-model.trim="twitter">
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col">
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon3">https://plus.google.com/</span>
                        <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" placeholder="UserName"
                             v-model.trim="google">
                    </div>
                </div>
                <div class="col">
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon3">https://www.linkedin.com/in/</span>
                        <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" placeholder="UserName"
                             v-model.trim="linkedin">
                    </div>
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
        props: ['address', 'token'],
        data() {
            return {
				imgsrc: 'https://dummyimage.com/200x200/000/ffffff.png&text=Click+Here!',
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
        mounted() {},
        methods: {
            toggleModal() {
                window.$('#imgModalNavigation').modal('toggle');
            },
            getData() {

            },
            save() {
                let data = [{constant: 'top-nav', address: this.address, logo: this.imgsrc}];
                data[0].facebook = this.facebook ? 'https://facebook.com/' + this.facebook : null;
                data[0].twitter = this.twitter ? 'https://twitter.com/' + this.twitter : null;
                data[0].google = this.google ? 'https://plus.google.com/' + this.google : null;
                data[0].linkedin = this.linkedin ? 'https://www.linkedin.com/in/' + this.linkedin : null;
                window.axios.put('/api/dashboard/contents/' + this.address, data, { headers: { 'Authorization': 'Bearer ' + this.token } })
				.then(res => {
					this.msg = res.data;
					this.getData();
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
