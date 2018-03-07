<template>
   <b-field label="Services">
        <b-table :data="items" :mobile-cards="true">
            <template slot-scope="props">
                <b-table-column field="heading" label="Title">
                    {{ props.row.heading }}
                </b-table-column>

                <b-table-column label="Actions" centered>
                    <services-form :token="token" :id="id" :heading="props.row.heading" :paragraph="props.row.paragraph" :order="props.row.order" update="update" @getData="getData" ></services-form>
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
                <services-form :token="token" :id="id" @getData="getData" :order="items.length"></services-form>
            </template>
        </b-table>
    </b-field>
</template>

<script>
import ServicesForm from './ServicesForm';

export default {
    name: 'About',
    props: ['id', 'token'],
    components: { ServicesForm },
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
            const loadingComponent = this.$loading.open();
            window.axios.get(`/api/dashboard/pages/${this.id}`, { headers: { 'Authorization': `Bearer ${this.token}` } })
            .then(async res => {
                let services = _.findWhere(res.data.sections, {title: 'services'});
                if (services) {
                    let data = _.groupBy(services.contents, (content) => content.order);                    
                    this.items = [];
                    await _.mapObject(data, (item, key) => {
                        let heading = _.findWhere(item, {type: 'heading'});                        
                        let paragraph = _.findWhere(item, {type: 'paragraph'});
                        this.items.push({
                            heading: heading.content,
                            paragraph: paragraph.content,
                            order: heading.order, 
                            id: heading.id
                        });
                    });
                    await loadingComponent.close();
                } else {
                    loadingComponent.close();
                }
            })
            .catch(err => console.log(err));
        },
        save() {
            let data = { paragraph: this.paragraph };
            window.axios.put(`/api/dashboard/pages/${this.id}`, data, { headers: { 'Authorization': `Bearer ${this.token}` } })
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

