<template>
    <section>
        <b-table :data="data">
            <template slot-scope="props">
                <b-table-column label="Title">
                    {{ props.row.title }}
                </b-table-column>

                <b-table-column label="Company">
                    {{ props.row.company }}
                </b-table-column>

                <b-table-column label="From year">
                    {{ props.row.from_year }}
                </b-table-column>

                <b-table-column label="To year">
                    {{ props.row.to_year }}
                </b-table-column>
                
                <b-table-column label="Actions">
                    <experience-cud u d :address="address" :token="token" @getData="getData" :sectionid="id" :id="props.row.id + ''"></experience-cud>
                </b-table-column>

            </template>
            <template slot="empty">
                <section class="section">
                    <div class="content has-text-grey has-text-centered">
                        <p>There are no Records!</p>
                    </div>
                </section>
            </template>
            <template slot="footer">
                <experience-cud c :address="address" :token="token" @getData="getData" :sectionid="id"></experience-cud>
            </template>
        </b-table>
    </section>
</template>

<script>
import moment from 'moment';
export default {
    name: 'Experience',
    props: ['id', 'token', 'address'],
    data () {
        return {
            data: []
        }
    },
     mounted() {
        this.getData();
    },
    methods: {
        getData() {
            window.axios.get('/api/dashboard/sections/' + this.id, { headers: { 'Authorization': 'Bearer ' + this.token } })
            .then(res => {
                this.data = [];
                let contents = res.data.contents;
                _.each(contents, content => {
                    let from_year = _.findWhere(content.extras, {type: 'from_year'});
                    let to_year = _.findWhere(content.extras, {type: 'to_year'});
                    this.data.push({ 
                        id: content.id,
                        title: content.title, 
                        company: content.content,
                        from_year: moment(from_year.content).calendar(),
                        to_year: to_year ? moment(to_year.content).calendar() : 'Current'
                    });
                });
            })
            .catch(err => console.log(err));
        }
    }
}
</script>

<style lang="css" scoped>
</style>