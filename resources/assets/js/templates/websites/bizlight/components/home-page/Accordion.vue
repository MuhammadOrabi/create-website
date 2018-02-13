<template>
    <b-field label="Accordion">
        <b-table :data="items" :mobile-cards="true">
            <template slot-scope="props">
                <b-table-column field="title" label="Title">
                    {{ props.row.title }}
                </b-table-column>

                <b-table-column label="Actions">
                    <span class="button is-info is-inverted" @click="showModal">
                        <b-icon pack="fa" icon="eye"></b-icon>
                    </span>
                    <span class="button is-primary is-inverted" @click="updateModal">
                        <b-icon pack="fa" icon="pencil-square-o"></b-icon>
                    </span>
                    <span class="button is-danger is-inverted" @click="deleteDialog">
                        <b-icon pack="fa" icon="trash-o"></b-icon>
                    </span>
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
                <div class="has-text-centered">
                    <span class="button is-link is-inverted" @click="createModal">
                        <b-icon pack="fa" icon="plus"></b-icon>
                    </span>
                </div>
            </template>
        </b-table>
    </b-field>
</template>

<script>
export default {

    name: 'Accordion',
    props: ['token', 'id', 'address'],
    data () {
        return {
            items: [{title: 'Title'}]
        }
    },
    methods: {
        createModal() {

        },
        updateModal() {

        },
        deleteDialog() {

        },
        showModal() {
            
        }
    }
}
</script>

<style lang="css" scoped>
</style>