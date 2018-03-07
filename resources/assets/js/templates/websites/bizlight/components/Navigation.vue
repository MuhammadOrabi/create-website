<template>
    <section>
        <b-field label="Links">
            <div class="block columns">
                <div class="column">
                    <b-input placeholder="Google plus" v-model.trim="links.google" ></b-input>
                </div>
                <div class="column">
                    <b-input placeholder="Linked In" v-model.trim="links.linkedin" ></b-input>
                </div>
                <div class="column">
                    <b-input placeholder="Facebook" v-model.trim="links.facebook" ></b-input>
                </div>
                <div class="column">
                    <b-input placeholder="Twitter" v-model.trim="links.twitter" ></b-input>
                </div>
            </div>
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
    props: ['address', 'token', 'id'],
    data() {
        return {
            links: {
                google: null,
                facebook: null,
                twitter: null,
                linkedin: null
            }
        }
    },
    mounted() {
        this.getData();
    },
    methods: {
        getData() {
            window.axios.get(`/api/constants/${this.id}`)
            .then(res => {
                let links = _.findWhere(res.data.contents, {type: 'links'});
                if (!links) return;
                let facebook = _.findWhere(links.extras, {type: 'facebook'});
                let google = _.findWhere(links.extras, {type: 'google'});
                let linkedin = _.findWhere(links.extras, {type: 'linkedin'});
                let twitter = _.findWhere(links.extras, {type: 'twitter'});
                this.links =  {
                    facebook: facebook ? facebook.content : null,
                    github: github ? github.content : null,
                    twitter: twitter ? twitter.content : null,
                    linkedin: linkedin ? linkedin.content : null,
                };
            })
            .catch(err => console.log(err));
        },
        save() {
            window.axios.put(`/api/dashboard/constants/${this.id}`, this.links, { headers: { 'Authorization': `Bearer ${this.token}` } })
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

<style>

</style>
