<template>
    <b-field label="Show Case">
        <div class="block">
            <b-modal :active.sync="isMediaModalActive" >
                <media v-bind="mediaProps" :imgUrl.sync="data.img" :active.sync="isMediaModalActive"></media>
            </b-modal>
            <b-field horizontal label="Image"><!-- Label left empty for spacing -->
                <p class="control">
                    <button class="button is-primary is-inverted" @click="isMediaModalActive = true">
                        <b-icon pack="fa" icon="picture-o"></b-icon>
                        <span>Media</span>
                    </button>
                </p>
                <section class="p-t-20 columns is-multiline is-centered">
                    <div class="column is-three-quarters" v-if="data.img">
                        <div class="notification">
                            <button class="delete" @click="data.img = null"></button>
                            <figure class="image is-2by1">
                                <img :src="data.img">
                            </figure>
                        </div>
                    </div>
                </section>
            </b-field>
            <b-field label="Title">
                <b-input v-model.trim="data.heading" minlength="10" maxlength="50"></b-input>
            </b-field>
            <b-field label="Short Paragraph">
                <b-input type="textarea" v-model.trim="data.paragraph" minlength="10" maxlength="300"></b-input>
            </b-field>
            <b-field horizontal><!-- Label left empty for spacing -->
                <p class="control">
                    <button class="button is-success" @click="save" :disabled="!valid">
                        <b-icon pack="fa" icon="check"></b-icon>
                        <span>Save</span>
                    </button>
                </p>
            </b-field>
        </div>
    </b-field>
</template>

<script>
export default {
    name: 'ShowCase',
    props: ['id', 'token', 'address'],
    data () {
        return {
            mediaProps: {
                address: this.address,
                token: this.token
            },
            isMediaModalActive: false,
            data: {
                img: null,
                heading: '',
                paragraph: ''
            }
        }
    },
    computed: {
        valid() {
            return this.data.img || this.data.heading || this.data.paragraph;
        }
    }, 
    mounted() {
        this.getData();
    },
    methods: {
        getData() {
            window.axios.get(`/api/dashboard/sections/${this.id}`, { headers: { 'Authorization': `Bearer ${this.token}` } })
            .then(res => {
                let img = _.findWhere(res.data.contents, {type: 'img'});
                this.data.img = img ? img.content : null;
                let heading = _.findWhere(res.data.contents, {type: 'heading'});
                this.data.heading = heading ? heading.content : null;
                let paragraph = _.findWhere(res.data.contents, {type: 'paragraph'});
                this.data.paragraph = paragraph ? paragraph.content : null;
            })
            .catch(err => console.log(err))
        },
        save() {
            window.axios.put(`/api/dashboard/sections/${this.id}`, this.data, { headers: { 'Authorization': `Bearer ${this.token}` } })
            .then(res => {
                this.$toast.open({
                    message: 'Saved Successfully',
                    type: 'is-success'
                });
                this.getData();
            }).catch(err => console.log(err));
        }
    }
}
</script>

<style lang="css" scoped>
</style>