<template>
    <section>
        <div class="has-text-centered">
            <span class="button is-info is-inverted" v-if="update" @click="showModal">
                <b-icon pack="fa" icon="eye"></b-icon>
            </span>
            <span class="button is-danger is-inverted" v-if="update" @click="deleteDialog">
                <b-icon pack="fa" icon="trash-o"></b-icon>
            </span>
            <span class="button is-primary is-inverted" v-if="update" @click="updateModal">
                <b-icon pack="fa" icon="pencil-square-o"></b-icon>
            </span>
            <span class="button is-link is-inverted" v-else @click="isFormModalActive = true">
                <b-icon pack="fa" icon="plus"></b-icon>
            </span>
        </div>    
        <b-modal :active.sync="isFormModalActive" has-modal-card>
            <div class="modal-card has-text-left">
                <header class="modal-card-head">
                    <p class="modal-card-title">accordion item</p>
                </header>
                <section class="modal-card-body">
                    <b-field label="Heading">
                        <b-input v-model="data.heading"  minlength="10" maxlength="50" placeholder="Heading" required :disabled="disabled"></b-input>
                    </b-field>

                    <b-field label="Paragraph">
                        <b-input v-model="data.paragraph"  minlength="10" maxlength="300" type="textarea" placeholder="Paragraph" required :disabled="disabled"></b-input>
                    </b-field>
                </section>
                <footer class="modal-card-foot">
                    <button class="button" type="button" @click="isFormModalActive = false">Close</button>
                    <button class="button is-primary" v-if="!disabled">Save</button>
                </footer>
            </div>
        </b-modal>
    </section>
</template>

<script>
export default {

    name: 'AccordionForm',
    props: ['token', 'id', 'update', 'heading', 'paragraph'],
    data () {
        return {
            data: {
                heading: null,
                paragraph: null
            },
            isFormModalActive: null,
            disabled: false
        }
    },
    mounted() {
        if (this.heading && this.paragraph && this.update) {
            this.data.heading = this.heading;
            this.data.paragraph = this.paragraph;
        }
    },
    methods: {
        save() {

        },
        deleteDialog() {

        },
        showModal() {
            this.disabled = true;
            this.isFormModalActive = true;       
        },
        updateModal() {
            this.disabled = false;
            this.isFormModalActive = true;       
        }
    }
}
</script>

<style lang="css" scoped>
</style>