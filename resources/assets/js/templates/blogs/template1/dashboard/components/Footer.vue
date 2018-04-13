<template>
    <section>
        <b-field  label="Footer Should Contains?">
            <div class="block">
                <b-checkbox v-model="data.footer" native-value="links">Links</b-checkbox>
                <b-checkbox v-model="data.footer" native-value="paragraph">Description</b-checkbox>  
            </div>
        </b-field>
        <b-field label="Links" v-if="data.footer.includes('links')">
            <div class="block columns">
                <div class="column">
                    <b-input placeholder="Github" v-model.trim="data.links.github" ></b-input>
                </div>
                <div class="column">
                    <b-input placeholder="Linked In" v-model.trim="data.links.linkedin" ></b-input>
                </div>
                <div class="column">
                    <b-input placeholder="Facebook" v-model.trim="data.links.facebook" ></b-input>
                </div>
                <div class="column">
                    <b-input placeholder="Twitter" v-model.trim="data.links.twitter" ></b-input>
                </div>
            </div>
        </b-field>
        <b-field label="Description" v-if="data.footer.includes('paragraph')">
            <b-input type="textarea" v-model="data.paragraph"></b-input>
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

    name: 'Footer',
    props: ['address', 'token', 'id'],
    data () {
        return {
            data: {
                footer: [],
                links: {
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
            window.axios.get('/api/constants/' + this.id)
            .then(res => {
                this.data.footer = _.pluck(_.where(res.data.contents, {active: 1}), 'type');
                let paragraph = _.findWhere(res.data.contents, {type: 'paragraph'});
                this.data.paragraph = paragraph ? paragraph.content : null;
                let links = _.findWhere(res.data.contents, {type: 'links'});
                if (links) {
                    let facebook = _.findWhere(links.extras, {type: 'facebook'});
                    let github = _.findWhere(links.extras, {type: 'github'});
                    let linkedin = _.findWhere(links.extras, {type: 'linkedin'});
                    let twitter = _.findWhere(links.extras, {type: 'twitter'});
                    this.data.links =  {
                        facebook: facebook ? facebook.content : null,
                        github: github ? github.content : null,
                        twitter: twitter ? twitter.content : null,
                        linkedin: linkedin ? linkedin.content : null,
                    };
                }
            })
            .catch(err => console.log(err));
        },
        save() {
            window.axios.put('/api/dashboard/constants/' + this.id, this.data, { headers: { 'Authorization': 'Bearer ' + this.token } })
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