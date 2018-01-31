<template>
    <section>
        <b-field label="Add Logo">
            <button class="button is-primary is-rounded is-inverted" @click="isMediaModalActive = true">
                <b-icon pack="fa" icon="picture-o"></b-icon>
            </button>
        </b-field>
        <section class="p-t-20 columns is-multiline is-centered">
            <div class="column is-one-fifth" v-if="data.logo">
                <div class="notification">
                    <button class="delete" @click="data.logo = null"></button>
                    <figure class="image is-128x128">
                        <img :src="data.logo">
                    </figure>
                </div>
            </div>
        </section>
        <b-modal :active.sync="isMediaModalActive" >
            <media v-bind="mediaProps" :imgUrl.sync="data.logo" :active.sync="isMediaModalActive"></media>
        </b-modal>
        <b-field  label="Footer Should Contains?">
            <div class="block">
                <b-checkbox v-model="data.footer" native-value="logo" v-if="data.logo">Logo</b-checkbox>
                <b-checkbox v-else disabled>Logo</b-checkbox>
                <b-checkbox v-model="data.footer" native-value="links">Links</b-checkbox>
                <b-checkbox v-model="data.footer" native-value="paragraph">Description</b-checkbox>  
            </div>
        </b-field>
        <div v-if="data.footer.includes('links')">
            <b-field  label="Links">
                <div class="block">
                    <b-checkbox v-model="data.links" native-value="github">Github</b-checkbox>
                    <b-checkbox v-model="data.links" native-value="linkedin">Linked In</b-checkbox>  
                    <b-checkbox v-model="data.links" native-value="facebook">Facebook</b-checkbox>
                    <b-checkbox v-model="data.links" native-value="twitter">Twitter</b-checkbox>  
                </div>
            </b-field>
            <b-field label="Links Username" v-if="data.links.length" >
                <div class="block columns">
                    <div class="column" v-if="data.links.includes('github')">
                        <b-input placeholder="Github" v-model="data.linksUsername.github" ></b-input>
                    </div>
                    <div class="column" v-if="data.links.includes('linkedin')">
                        <b-input placeholder="Linked In" v-model="data.linksUsername.linkedin" ></b-input>
                    </div>
                    <div class="column" v-if="data.links.includes('facebook')">
                        <b-input placeholder="Facebook" v-model="data.linksUsername.facebook" ></b-input>
                    </div>
                    <div class="column" v-if="data.links.includes('twitter')">
                        <b-input placeholder="Twitter" v-model="data.linksUsername.twitter" ></b-input>
                    </div>
                </div>
            </b-field>
        </div>
        <b-field label="Description" v-if="data.footer.includes('paragraph')">
            <b-input type="textarea"></b-input>
        </b-field>
        <b-field><!-- Label left empty for spacing -->
            <p class="control has-text-centered m-t-10">
                <button class="button is-primary" @click="save">Save</button>
            </p>
        </b-field>
    </section>
</template>

<script>
export default {

    name: 'Navigation',
    props: ['address', 'token'],
    data () {
        return {
            mediaProps: {
                address: this.address,
                token: this.token
            },
            isMediaModalActive: false,
            data: {
                logo: null,
                links: [],
                footer: [],
                linksUsername: {
                    facebook: null,
                    github: null,
                    twitter: null,
                    linkedin: null,
                },
                paragraph: null
            },
        }
    },
    mounted() {
        this.getData();
    },
    methods: {
        getData() {

        },
        save() {

        }
    }
}
</script>

<style lang="css" scoped>
</style>