<template>
    <section class="hero is-medium is-light is-bold">
        <div class="hero-body">
            <div class="container">
                <article class="media">
                    <figure class="media-left" v-if="data.img">
                        <p class="image is-128x128">
                            <img :src="data.img">
                        </p>
                    </figure>
                    <div class="media-content">
                        <h1 class="title ">{{ data.name }}</h1>
                        <h1 class="subtitle" v-if="data.title">{{ data.title }}</h1>
                        <br v-else>
                    </div>
                    <div class="media-right">
                        <button class="button is-primary" @click="isFormModalActive = true">
                            <b-icon icon="border-color"></b-icon>
                            <span>Edit</span>
                        </button>
                        <b-modal :active.sync="isFormModalActive" has-modal-card>
                            <div>
                                <div class="modal-card" style="width: auto">
                                    <header class="modal-card-head">
                                        <p class="modal-card-title">Update Info</p>
                                    </header>
                                    <section class="modal-card-body">
                                        <b-field label="Avatar">
                                            <button class="button is-info is-inverted" type="button" @click="isMediaModalActive = true">
                                                <span>Media</span>
                                                <b-icon pack="fa" icon="picture-o"></b-icon>
                                            </button>
                                            <div class="notification" v-if="data.img">
                                                <button class="delete" @click="data.img = null"></button>
                                                <figure class="image is-128x128">
                                                    <img :src="data.img">
                                                </figure>
                                            </div>
                                        </b-field>

                                        <b-modal :active.sync="isMediaModalActive" >
                                            <media v-bind="{address: this.address, token: this.token}" :imgUrl.sync="data.img" :active.sync="isMediaModalActive"></media>
                                        </b-modal>

                                        <b-field label="Name">
                                            <b-input type="text" placeholder="Your Name" v-model="data.name"></b-input>
                                        </b-field>

                                        <b-field label="Title">
                                            <b-input type="text" placeholder="Your Title" v-model="data.title"></b-input>
                                        </b-field>

                                    </section>
                                    <footer class="modal-card-foot">
                                        <button class="button is-primary" @click="save">Save</button>
                                        <button class="button" type="button" @click="isFormModalActive = false">Close</button>
                                    </footer>
                                </div>
                            </div>
                        </b-modal>
                    </div>
                </article>
            </div>
        </div>
    </section>
</template>

<script>

export default {
    name: 'Profile',
    props: ['address'],
    data () {
        return {
            data: {
                name: '',
                title: '',
                img: null
            },
            isFormModalActive: false,
            isMediaModalActive: false,
        }
    },
    computed: {
        auth() {
            return this.$store.getters.session(this.address);
        },
        token() {
            return this.auth.token;
        }
    },
    mounted() {
        this.getData();
    },
    methods: {
        getData() {
            window.axios.get(`/api/users/${this.auth.id}/${this.address}`)
            .then(res => {
                this.data.name = res.data.name;
                this.data.title = res.data.title;
                let img = _.findWhere(res.data.extras, {type: 'avatar'});
                this.data.img = img ? img.content : null;
            })
            .catch(err => console.log(err));
        },
        save() {
            window.axios.put('/api/users/' + this.auth.id, this.data, { headers: { 'Authorization': 'Bearer ' + this.token } })
            .then(res => {
                this.$toast.open({
                    message: 'Saved Successfully',
                    type: 'is-success'
                });
                this.getData();
            })
            .catch(err => console.log(err));
        }
    }
}
</script>

<style lang="css" scoped>
</style>