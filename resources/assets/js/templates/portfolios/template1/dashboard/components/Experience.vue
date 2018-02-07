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
export default {

    name: 'Experience',
    props: ['id', 'token', 'address'],
    data () {
        return {
            data: [
                // { title: '', company: '', from_year: '', to_year: '' },
            ]
        }
    }
}
</script>

<style lang="css" scoped>
</style>