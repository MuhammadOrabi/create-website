<template>
    <b-field label="Horizontal List">
        <b-table :data="items" :mobile-cards="true">
            <template slot-scope="props">
                <b-table-column field="heading" label="Title">
                    {{ props.row.heading }}
                </b-table-column>

                <b-table-column label="Actions" centered>
                    <horizontal-list-form :token="token" :id="id" :content="props.row.id" :heading="props.row.heading" :address="address" :img="props.row.img"
                        :paragraph="props.row.paragraph" :order="props.row.order" update="update" @getData="getData" ></horizontal-list-form>
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
                <horizontal-list-form :token="token" :id="id" @getData="getData" :order="items.length" :address="address"></horizontal-list-form>
            </template>
        </b-table>
    </b-field>
</template>

<script>
import HorizontalListForm from './HorizontalListForm.vue';
export default {
    name: 'HorizontalList',
    props: ['token', 'id', 'address'],
    components: {HorizontalListForm},
    data () {
        return {
            items: []
        }
    },
    mounted() {
        this.getData();
    },
    methods: {
        getData() {
            const loadingComponent = this.$loading.open()
            window.axios.get(`/api/dashboard/sections/${this.id}`, { headers: { 'Authorization': `Bearer ${this.token}` } })
            .then(async res => {
                let data = _.groupBy(res.data.contents, (content) => content.order);
                this.items = [];
                await _.mapObject(data, (item, key) => {
                    let heading = _.findWhere(item, {type: 'heading'});                        
                    let paragraph = _.findWhere(item, {type: 'paragraph'});
                    let img = _.findWhere(item, {type: 'img'});
                    this.items.push({
                        heading: heading.content,
                        paragraph: paragraph.content,
                        order: heading.order, 
                        id: heading.id, 
                        img: img.content 
                    });
                });
                await loadingComponent.close();
            })
            .catch(err => console.log(err));
        }
    }
}
</script>

<style lang="css" scoped>
</style>