<template>
    <div>
        <section class="columns">
            <div class="column">
                <b-field label="Brand">
                    <b-input placeholder="Brand .." v-model="data.name"></b-input>
                </b-field>
            </div>
            <div class="column">
                <b-field label="Logo">
                    <button class="button is-info is-inverted" @click="isMediaModalActive = true">
                        <span>Media</span>
                        <b-icon pack="fa" icon="picture-o"></b-icon>
                    </button>
                </b-field>
                <section class="p-t-20 columns is-multiline is-centered">
                    <div class="column is-half" v-if="data.logo">
                        <div class="notification">
                            <button class="delete" @click="data.logo = null"></button>
                            <figure class="image is-128x128">
                                <img :src="data.logo">
                            </figure>
                        </div>
                    </div>
                </section>
            </div>
        </section>
        <b-modal :active.sync="isMediaModalActive" >
            <media v-bind="mediaProps" :imgUrl.sync="data.logo" :active.sync="isMediaModalActive"></media>
        </b-modal>
        <button class="button is-success" @click="save">Save</button>
    </div>
</template>

<script>
export default {

    name: 'Settings',
    props: ['address', 'token', 'id'],
    data () {
        return {
            mediaProps: {
                address: this.address,
                token: this.token
            },
            data: {
                logo: null,
                name: null
            },
            isMediaModalActive: false
        }
    },
    mounted() {
        this.getData();
    },
    methods: {
        getData() {
            window.axios.get('/api/sites/info/site-info/' + this.address)
            .then(res => {
                let logo = _.findWhere(res.data.extras, {type: 'logo'});
                this.data.logo = logo ? logo.content : null;
                this.data.name = res.data.name;
            })
            .catch(err => console.log(err));
        },
        save() {
            window.axios.put('/api/dashboard/sites/' + this.id, this.data, { headers: { 'Authorization': 'Bearer ' + this.token } })
            .then(res => {
                this.getData();
                this.$toast.open({
                    message: 'Saved Successfully',
                    type: 'is-success'
                });
            })
            .catch(err => console.log(err));
        }
    }
}
</script>

<style lang="css" scoped>
</style>