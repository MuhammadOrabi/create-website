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
        <b-field grouped>
            <b-field label="Title" expanded>
                <b-input v-model="data.title" placeholder="Title" expanded></b-input>
            </b-field>
            <b-field label="Subtitle" expanded>
                <b-input v-model="data.subtitle" placeholder="Subtitle"></b-input>
            </b-field>
        </b-field>
        <b-field grouped>
            <b-field label="Github" expanded>
                <b-input placeholder="Github" v-model.trim="data.links.github" ></b-input>
            </b-field>
            <b-field label="Linked In" expanded>
                <b-input placeholder="Linked In" v-model.trim="data.links.linkedin" ></b-input>
            </b-field>
            <b-field label="Facebook" expanded>
                <b-input placeholder="Facebook" v-model.trim="data.links.facebook" ></b-input>
            </b-field>
            <b-field label="Twitter" expanded>
                <b-input placeholder="Twitter" v-model.trim="data.links.twitter" ></b-input>
            </b-field>
        </b-field>
        <b-field><!-- Label left empty for spacing -->
            <p class="control">
                <button class="button is-primary" @click="save">Save</button>
            </p>
        </b-field>
    </section>
</template>

<script>
export default {

    name: 'LeftShowCase',
    props: ['id', 'address', 'token'],
    data () {
        return {
            mediaProps: {
                address: this.address,
                token: this.token
            },
            data: {
                img: null,
                title: null,
                subtitle: null,
                links: {
                    facebook: null,
                    twitter: null,
                    github: null,
                    linkedin: null
                }
            },
            isMediaModalActive: false
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
                let subtitle = _.findWhere(res.data.contents, {type: 'subtitle'});
                this.data.subtitle = subtitle ? subtitle.content : null;
                let github = _.findWhere(res.data.contents, {type: 'github'});
                this.data.links.github = github ? github.content : null;
                let twitter = _.findWhere(res.data.contents, {type: 'twitter'});
                this.data.links.twitter = twitter ? twitter.content : null;
                let facebook = _.findWhere(res.data.contents, {type: 'facebook'});
                this.data.links.facebook = facebook ? facebook.content : null;
                let linkedin = _.findWhere(res.data.contents, {type: 'linkedin'});
                this.data.links.linkedin = linkedin ? linkedin.content : null;
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