<template>
    <b-field label="Accordion and an image">
        <div class="block">
            <b-modal :active.sync="isMediaModalActive" >
                <media v-bind="mediaProps" :imgUrl.sync="img" :active.sync="isMediaModalActive"></media>
            </b-modal>
            <b-field horizontal label="Image"><!-- Label left empty for spacing -->
                <p class="control">
                    <button class="button is-primary is-inverted" @click="isMediaModalActive = true">
                        <b-icon pack="fa" icon="picture-o"></b-icon>
                        <span>Media</span>
                    </button>
                </p>
                <section class="p-t-20 columns is-multiline is-centered">
                    <div class="column is-three-quarters" v-if="img">
                        <div class="notification">
                            <button class="delete" @click="img = null"></button>
                            <figure class="image is-2by1">
                                <img :src="img">
                            </figure>
                        </div>
                    </div>
                </section>
            </b-field>
            <b-field label="Accordion">
                <b-table :data="items" :mobile-cards="true">
                    <template slot-scope="props">
                        <b-table-column field="heading" label="Title">
                            {{ props.row.heading }}
                        </b-table-column>

                        <b-table-column label="Actions" centered>
                            <accordion-form :token="token" :id="id" :content="props.row.id" :heading="props.row.heading"
                             :paragraph="props.row.paragraph" :order="props.row.order" update="update" @getData="getData" ></accordion-form>
                        </b-table-column>
                    </template>
                    
                    <template slot="empty">
                        <section class="section">
                            <div class="content has-text-grey has-text-centered">
                                <p>
                                    <b-icon icon="emoticon-sad" size="is-large"></b-icon>
                                </p>
                                <p>The list is empty, add items here</p>
                                <p>
                                    <b-icon icon="arrow-down" size="is-large"></b-icon>
                                </p>
                            </div>
                        </section>
                    </template>
                    <template slot="footer" >
                        <accordion-form :token="token" :id="id" @getData="getData" :order="items.length"></accordion-form>
                    </template>
                </b-table>
            </b-field>
        </div>
    </b-field>
</template>

<script>
import AccordionForm from './AccordionForm.vue';

export default {
    name: 'Accordion',
    components: {AccordionForm},
    props: ['token', 'id', 'address'],
    data () {
        return {
            items: [],
            isFormModalActive: false,
            isMediaModalActive: false,
            img: null,
            mediaProps: {
                address: this.address,
                token: this.token
            }
        }
    },
    mounted() {
        this.getData();
    },
    watch: {
        img(newVal, oldVal) {
            if (newVal !== oldVal) {
                this.saveImage();
            }            
        }
    },
    methods: {
        getData() {
            const loadingComponent = this.$loading.open()
            window.axios.get(`/api/dashboard/sections/${this.id}`, { headers: { 'Authorization': `Bearer ${this.token}` } })
            .then(async res => {
                let img = _.findWhere(res.data.contents, {type: 'img'});
                this.img = img ? img.content : null;
                let accordionData = _.groupBy(res.data.contents, (content) => content.order);
                this.items = [];
                await _.mapObject(accordionData, (item, key) => {
                    if (key > 0) {
                        let heading = _.findWhere(item, {type: 'heading'});                        
                        let paragraph = _.findWhere(item, {type: 'paragraph'});
                        this.items.push({heading: heading.content, paragraph: paragraph.content, order: heading.order, id: heading.id });
                    }
                });
                await loadingComponent.close();
            })
            .catch(err => console.log(err));
        },
        saveImage() {
            window.axios.put('/api/dashboard/sections/' + this.id, {img: this.img}, { headers: { 'Authorization': 'Bearer ' + this.token } })
            .then(res => {})
            .catch(err => console.log(err));
        }
    }
}
</script>

<style lang="css" scoped>
</style>