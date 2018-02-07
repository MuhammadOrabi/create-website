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
                <button class="button is-primary">Save</button>
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
    }
}
</script>

<style lang="css" scoped>
</style>