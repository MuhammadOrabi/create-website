<template>
        <section>
        <div class="buttons has-addons is-centered">
            <button class="button is-link is-inverted" v-if="c" @click="createModal" :disabled="!active">
                <b-icon pack="fa" icon="plus"></b-icon>
            </button>
            <button class="button is-primary is-inverted" v-if="u" @click="updateModal" :disabled="!active">
                <b-icon pack="fa" icon="pencil-square-o"></b-icon>
            </button>
            <button class="button is-danger is-inverted" v-if="d" @click="deleteDialog" :disabled="!active">
                <b-icon pack="fa" icon="trash-o"></b-icon>
            </button>
        </div>
        <b-modal :active.sync="isModalActive">
            <div class="box">
                <h1 v-if="c" class="title is-1 has-text-centered">Add Experience</h1>
                <h1 v-if="u" class="title is-1 has-text-centered">Update</h1>
                <b-field grouped>
                    <b-field label="Title">
                        <b-input v-model.trim="data.title" placeholder="Title"></b-input>
                    </b-field>

                    <b-field label="Company">
                        <b-input v-model.trim="data.company" placeholder="Company"></b-input>
                    </b-field>
                </b-field>

                <b-field grouped>
                    <b-field label="From">
                        <b-datepicker v-model="data.from_year" icon="calendar-today"></b-datepicker>
                    </b-field>
                    <b-field label="To">
                        <b-datepicker v-model="data.to_year" icon="calendar-today" :min-date="data.from_year" :disabled="data.current"></b-datepicker>
                    </b-field>
                </b-field>
                <b-field label="Still Work there?">
                    <b-checkbox v-model="data.current" size="is-small">Current</b-checkbox>
                </b-field>
                <button class="button is-primary" @click="save" :disabled="!valid">save</button>
            </div>
        </b-modal>
    </section>
</template>

<script>
export default {

    name: 'Experience-CUD',
    props: {token: String, address: String, id: String, sectionid: String, c: Boolean, u: Boolean, d: Boolean, r: Boolean, active: Boolean},
    data () {
        return {
            isModalActive: false,
            data: { title: '', company: '', from_year: null, to_year: null, current: false },
        }
    },
    computed: {
        valid() {
            return (this.data.title.length !== 0 && this.data.company.length !== 0 && this.data.from_year)  && (this.data.to_year || this.data.current);
        }
    },
    methods: {
        createModal() {
            this.data = { title: '', company: '', from_year: null, to_year: null, current: false };
            this.isModalActive = true;
        },
        updateModal() {
            this.getData();
            this.isModalActive = true;  
        },
        deleteDialog() {
            this.$dialog.confirm({
                title: 'Deleting Experience',
                message: 'Are you sure you want to <b>delete</b> this Experience?<br> This action cannot be undone.',
                confirmText: 'Delete Experience',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => this.destroy()
            });
        },
        save() {
            window.axios.put('/api/dashboard/sections/' + this.sectionid, this.data, { headers: { 'Authorization': 'Bearer ' + this.token } })
            .then(() => {
               this.$emit('getData');
               this.$toast.open({
                    message: 'Saved Successfully',
                    type: 'is-success'
                });
               this.isModalActive = false;
            })
            .catch(err => console.log(err));
        },
        getData() {
            const vm = this;
            window.axios.get('/api/dashboard/contents/' + vm.id, { headers: { 'Authorization': 'Bearer ' + vm.token } })
            .then(res => {
                let content = res.data;
                let from_year = _.findWhere(content.extras, {type: 'from_year'});
                let to_year = _.findWhere(content.extras, {type: 'to_year'});
                this.data.title = content.title;
                this.data.company = content.content;
                this.data.from_year = new Date(from_year.content);
                this.data.to_year = to_year ?  new Date(to_year.content) : null;
                this.data.current = to_year ? false : true;
            })
            .catch(err => console.log(err));
        },
        destroy() {
            const vm = this;
            window.axios.delete('/api/dashboard/contents/' + vm.id, { headers: { 'Authorization': 'Bearer ' + vm.token } })
            .then(() => {
                this.$emit('getData');                   
                this.$toast.open('Experience deleted!');
            })
            .catch(err => console.log(err));
        }
    }
}
</script>

<style lang="css" scoped>
</style>