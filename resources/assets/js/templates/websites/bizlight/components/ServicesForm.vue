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
                    <p class="modal-card-title">Add to services</p>
                </header>
                <section class="modal-card-body" v-if="disabled">
                    <h1 class="title">{{ data.heading }}</h1>
                    <p>{{ data.paragraph }}</p>                    
                </section>
                <section class="modal-card-body" v-else>
                    <b-field label="Heading">
                        <b-input v-model="data.heading"  minlength="10" maxlength="50" placeholder="Heading" required ></b-input>
                    </b-field>
                    <b-field label="Paragraph">
                        <b-input v-model="data.paragraph"  minlength="10" maxlength="300" type="textarea" 
                            placeholder="Paragraph" required></b-input>
                    </b-field>
                </section>
                <footer class="modal-card-foot">
                    <button class="button" type="button" @click="isFormModalActive = false">Close</button>
                    <button class="button is-primary" v-if="!disabled" @click="save">Save</button>
                </footer>
            </div>
        </b-modal>
    </section>
</template>

<script>
export default {

    name: 'ServicesForm',
    props: ['token', 'id', 'update', 'heading', 'paragraph', 'order'],
    data () {
        return {
            data: {
                heading: null,
                paragraph: null,
            },
            isFormModalActive: null,
            disabled: false,
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
            let order = this.update ? this.order : this.order + 1;
            let data = _.extend(this.data, {order: order});
            window.axios.put(`/api/dashboard/pages/${this.id}`, data, { headers: { 'Authorization': `Bearer ${this.token}` } })
            .then(res => {
                this.$emit('getData');
                this.isFormModalActive = false;
            })
            .catch(err => console.log(err));
        },
        deleteDialog() {            
            this.$dialog.confirm({
                title: 'Deleting services item',
                message: 'Are you sure you want to <b>delete</b> this?<br> This action cannot be undone.',
                confirmText: 'Delete services item',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => this.destroy()
            });
        },
        showModal() {
            this.disabled = true;
            this.isFormModalActive = true;       
        },
        updateModal() {
            this.disabled = false;
            this.isFormModalActive = true;       
        },
        destroy() {
            window.axios.delete('/api/dashboard/contents/' + this.content, { headers: { 'Authorization': 'Bearer ' + this.token } })
            .then(res => {
                this.$emit('getData');
                this.isFormModalActive = false;
            })
            .catch(err => console.log(err));
        }
    }
}
</script>

<style lang="css" scoped>
</style>