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
                        <b-table-column field="title" label="Title" centered>
                            {{ props.row.title }}
                        </b-table-column>

                        <b-table-column label="Actions" centered>
                            <accordion-form :token="token" :id="id" :heading="props.row.title" :paragraph="props.row.paragraph" update="update"></accordion-form>
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
                        <accordion-form :token="token" :id="id"></accordion-form>
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
            items: [{title: 'Title', paragraph: 'Paragraph'}],
            isFormModalActive: false,
            isMediaModalActive: false,
            img: null,
            mediaProps: {
                address: this.address,
                token: this.token
            }
        }
    },
    methods: {
        
    }
}
</script>

<style lang="css" scoped>
</style>