<template>
    <section>
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

            </template>
            <template slot="empty">
                <section class="section">
                    <div class="content has-text-grey has-text-centered">
                        <p>There are no Records!</p>
                    </div>
                </section>
            </template>
            <template slot="footer">
                <education-cud c :address="address" :token="token" @getData="getData" :sectionid="id"></education-cud>
            </template>
        </b-table>
    </section>
</template>

<script>
    export default {
        name: 'Education',
        props: ['address', 'id', 'token'],
        data() {
            return {
                data: [
                    // { school: '', degree: '', field_of_study: '', grade: '', from_year: '', to_year: '' },
                ]
            }
        },
        methods: {
            getData() {

            }
        }
    }
</script>