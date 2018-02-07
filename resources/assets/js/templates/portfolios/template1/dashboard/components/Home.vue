<template>
    <section>
        <div class="column">
            <b-field label="Image">
                <button class="button is-info is-inverted" @click="isMediaModalActive = true">
                    <span>Media</span>
                    <b-icon pack="fa" icon="picture-o"></b-icon>
                </button>
            </b-field>
            <section class="p-t-20 columns is-multiline is-centered">
                <div class="column is-half" v-if="data.img">
                    <div class="notification">
                        <button class="delete" @click="data.img = null"></button>
                        <figure class="image is-128x128">
                            <img :src="data.img">
                        </figure>
                    </div>
                </div>
            </section>
            <b-modal :active.sync="isMediaModalActive" >
                <media v-bind="mediaProps" :imgUrl.sync="data.img" :active.sync="isMediaModalActive"></media>
            </b-modal>
        </div>
        <b-field label="Title">
            <b-input v-model.trim="data.title" expanded></b-input>
        </b-field>
         <b-field label="Short Description">
            <b-input type="textarea" v-model.trim="data.paragraph"></b-input>
        </b-field>
        <b-field><!-- Label left empty for spacing -->
            <p class="control">
                <button class="button is-primary" @click="save" :disabled="!valid">Save</button>
            </p>
        </b-field>
    </section>
</template>

<script>
export default {

    name: 'Home',
    props: ['token', 'id', 'address'],
    data () {
        return {
            mediaProps: {
                address: this.address,
                token: this.token
            },
            data: {
                img: null,
                title: null,
                paragraph: null
            },
            isMediaModalActive: false
        }
    },
    computed: {
        valid() {
            return this.data.img && this.data.title && this.data.paragraph;
        }
    },
    mounted() {
        this.getData();
    },
    methods: {
        getData() {
            window.axios.get('/api/dashboard/sections/' + this.id, { headers: { 'Authorization': 'Bearer ' + this.token } })
            .then(res => {
                let img = _.findWhere(res.data.contents, {type: 'img'});
                this.data.img = img ? img.content : null;
                let title = _.findWhere(res.data.contents, {type: 'title'});
                this.data.title = title ? title.content : null;
                let paragraph = _.findWhere(res.data.contents, {type: 'paragraph'});
                this.data.paragraph = paragraph ? paragraph.content : null;
            })
            .catch(err => console.log(err));
        },
        save() {
            window.axios.put('/api/dashboard/sections/' + this.id, this.data, { headers: { 'Authorization': 'Bearer ' + this.token } })
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