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
                <h1 v-if="c" class="title is-1 has-text-centered">Add Education</h1>
                <h1 v-if="u" class="title is-1 has-text-centered">Update</h1>
                <b-field grouped group-multiline>
                    <b-field label="School*">
                        <b-input v-model.trim="data.school" placeholder="School"></b-input>
                    </b-field>

                    <b-field label="Field Of Study*">
                        <b-input v-model.trim="data.field_of_study" placeholder="Field Of Study"></b-input>
                    </b-field>
                </b-field>

                <b-field grouped>
                    <b-field label="Degree">
                        <b-input v-model.trim="data.degree" placeholder="Degree"></b-input>
                    </b-field>

                    <b-field label="Grade">
                        <b-input v-model.trim="data.grade" placeholder="Grade"></b-input>
                    </b-field>
                </b-field>
                    
                <b-field grouped group-multiline>
                    <b-field label="From*">
                        <b-datepicker v-model="data.from_year" icon="calendar-today" ></b-datepicker>
                    </b-field>
                    <b-field label="To*">
                        <b-datepicker v-model="data.to_year" icon="calendar-today" :min-date="data.from_year"  :disabled="data.current"></b-datepicker>
                    </b-field>
                </b-field>  

                <b-field label="Still study there?">
                    <b-checkbox v-model="data.current" size="is-small">Current</b-checkbox>
                </b-field>
                <button class="button is-primary" @click="save" :disabled="!valid">Save</button>
            </div>
        </b-modal>
    </section>
</template>

<script>
import moment from 'moment';
export default {
    name: 'Education-CUD',
    props: {token: String, address: String, id: String, sectionid: String, c: Boolean, u: Boolean, d: Boolean, r: Boolean, active: Boolean},
    data () {
        return {
            isModalActive: false,
            data: { school: '', degree: '', field_of_study: '', grade: '', from_year: null, to_year: null, current: false },
        }
    },
    computed: {
        valid() {
            return (this.data.school.length !== 0 && this.data.field_of_study.length !== 0 && this.data.from_year) && (this.data.to_year || this.data.current);
        }
    },
    methods: {
        moment,
        createModal() {
            this.data = { school: '', degree: '', field_of_study: '', grade: '', from_year: null, to_year: null, current: false};
            this.isModalActive = true;
        },
        updateModal() {
            this.getData();
            this.isModalActive = true;
        },
        deleteDialog() {
            this.$dialog.confirm({
                title: 'Deleting Education',
                message: 'Are you sure you want to <b>delete</b> this Education?<br> This action cannot be undone.',
                confirmText: 'Delete Education',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => this.destroy()
            });
        },
        save() {
            window.axios.put('/api/dashboard/sections/' + this.sectionid, this.data, { headers: { 'Authorization': 'Bearer ' + this.token } })
            .then(res => {
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
                let degree = _.findWhere(content.extras, {type: 'degree'});
                let grade = _.findWhere(content.extras, {type: 'grade'});
                this.data.school = content.title; 
                this.data.field_of_study = content.content;
                this.data.degree = degree ? degree.content : '';
                this.data.grade = grade ? grade.content : ''; 
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
                this.$toast.open('Education deleted!');
            })
            .catch(err => console.log(err));
        }
    }
}
</script>

<style lang="css" scoped>
</style>