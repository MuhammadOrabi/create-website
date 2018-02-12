<template>
    <section>
        <section-status :token="token" :id="id" @getData="getData" :active="active"></section-status>
        <b-table :data="data">
            <template slot-scope="props">
                <b-table-column label="School">
                    {{ props.row.school }}
                </b-table-column>

                <b-table-column label="Degree">
                    {{ props.row.degree }}
                </b-table-column>

                <b-table-column label="Field Of Study">
                    {{ props.row.field_of_study }}
                </b-table-column>

                <b-table-column label="Grade">
                    {{ props.row.grade }}
                </b-table-column>

                <b-table-column label="From year">
                    {{ props.row.from_year }}
                </b-table-column>

                <b-table-column label="To year">
                    {{ props.row.to_year }}
                </b-table-column>

                <b-table-column label="Actions">
                    <education-cud u d :address="address" :token="token" @getData="getData" :sectionid="id" :id="props.row.id + ''" :active="active"></education-cud>
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
                <education-cud c :address="address" :token="token" @getData="getData" :sectionid="id" :active="active"></education-cud>
            </template>
        </b-table>
    </section>
</template>

<script>
    import moment from 'moment';
    export default {
        name: 'Education',
        props: ['address', 'id', 'token'],
        data() {
            return {
                data: [],
                active: 1
            }
        },
        mounted() {
            this.getData();
        },
        methods: {
            getData() {
                window.axios.get('/api/dashboard/sections/' + this.id, { headers: { 'Authorization': 'Bearer ' + this.token } })
                .then(res => {
                    this.active = res.data.active;
                    this.data = [];
                    let contents = res.data.contents;
                    _.each(contents, content => {
                        let from_year = _.findWhere(content.extras, {type: 'from_year'});
                        let to_year = _.findWhere(content.extras, {type: 'to_year'});
                        let degree = _.findWhere(content.extras, {type: 'degree'});
                        let grade = _.findWhere(content.extras, {type: 'grade'});
                        this.data.push({ 
                            id: content.id,
                            school: content.title, 
                            field_of_study: content.content,
                            degree: degree ? degree.content : null,
                            grade: grade ? grade.content : null, 
                            from_year: moment(from_year.content).calendar(),
                            to_year: to_year ? moment(to_year.content).calendar() : 'Current',
                        });
                    });
                })
                .catch(err => console.log(err));
            }
        }
    }
</script>