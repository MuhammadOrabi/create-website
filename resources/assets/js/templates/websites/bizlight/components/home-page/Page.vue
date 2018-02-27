<template>
    <section>
        <b-tabs position="is-centered" class="block">
            <b-tab-item label="Show Case" v-if="showcase">
                <section-status :id="showcase" :token="token" />  
                <show-case :token="token" :id="showcase" :address="address"></show-case>
            </b-tab-item>
            <b-tab-item label="Accordion and an image" v-if="accordion">
                <section-status :id="accordion" :token="token" />                  
                <accordion :token="token" :id="accordion" :address="address"></accordion>
            </b-tab-item>
            <b-tab-item label="Horizontal List" v-if="horizontalList">
                <section-status :id="horizontalList" :token="token" />                  
                <horizontal-list :token="token" :id="horizontalList" :address="address"></horizontal-list>
            </b-tab-item>
            <b-tab-item label="Paragraph and an Image" v-if="paragraphImage">
                <section-status :id="paragraphImage" :token="token" />                  
                <paragraph-image :token="token" :id="paragraphImage" :address="address"></paragraph-image>
            </b-tab-item>
        </b-tabs>
    </section>
</template>

<script>
import ShowCase from './ShowCase.vue';
import Accordion from './Accordion.vue';
import HorizontalList from './HorizontalList.vue';
import ParagraphImage from './ParagraphImage.vue';

export default {
    name: 'Page',
    props: ['token', 'id'],
    components: {
        ShowCase, Accordion, HorizontalList, ParagraphImage
    },
    data () {
        return {
            address: '',
            showcase: null,
            accordion: null,
            horizontalList: null,
            paragraphImage: null
        }
    },
    mounted() {
        this.getData();
    },
    methods: {
        getData() {
            window.axios.get(`/api/dashboard/pages/${this.id}`, { headers: { 'Authorization': 'Bearer ' + this.token }})
            .then(res => {
                let sections = res.data.sections;
                this.address = res.data.site.address;
                let showcase = _.findWhere(sections, {title: 'show-case'});
                this.showcase = showcase.id;
                let accordion = _.findWhere(sections, {title: 'accordion'});
                this.accordion = accordion.id;
                let horizontalList = _.findWhere(sections, {title: 'horizontal-list'});
                this.horizontalList = horizontalList.id;
                let paragraphImage = _.findWhere(sections, {title: 'paragraph-image'});
                this.paragraphImage = paragraphImage.id;
            })
            .catch(err => console.log(err))
        }
    }
}
</script>

<style lang="css" scoped>
</style>