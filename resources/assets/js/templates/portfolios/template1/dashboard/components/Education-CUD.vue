<template>
    <section>
        <div class="buttons has-addons is-centered">
            <span class="button is-link is-inverted" v-if="c" @click="createModal">
                <b-icon pack="fa" icon="plus"></b-icon>
            </span>
            <span class="button is-primary is-inverted" v-if="u" @click="updateModal">
                <b-icon pack="fa" icon="pencil-square-o"></b-icon>
            </span>
            <span class="button is-danger is-inverted" v-if="d" @click="deleteDialog">
                <b-icon pack="fa" icon="trash-o"></b-icon>
            </span>
        </div>
        <b-modal :active.sync="isModalActive">
            <div class="box">
                <h1 v-if="c" class="title is-1 has-text-centered">Add Education</h1>
                <h1 v-if="u" class="title is-1 has-text-centered">Update</h1>
                <b-field grouped>
                    <b-field label="School">
                        <b-input v-model.trim="data.school" placeholder="School"></b-input>
                    </b-field>

                    <b-field label="Field Of Study">
                        <b-input v-model.trim="data.field_of_study" placeholder="Field Of Study"></b-input>
                    </b-field>
                </b-field>

                <b-field grouped>
                    <b-field label="Grade">
                        <b-input v-model.trim="data.grade" placeholder="Grade"></b-input>
                    </b-field>

                    <b-field label="Degree">
                        <b-input v-model.trim="data.degree" placeholder="Degree"></b-input>
                    </b-field>
                </b-field>
                    
                <b-field grouped>
                    <b-field label="From">
                        <b-datepicker v-model="data.from_year" placeholder="Click to select..." icon="calendar-today"></b-datepicker>
                    </b-field>
                    <b-field label="To">
                        <b-datepicker v-model="data.to_year" placeholder="Click to select..." icon="calendar-today"></b-datepicker>
                    </b-field>
                </b-field>  
                <button class="button is-primary" v-if="c" @click="create" :disabled="!valid">Add</button>
                <button class="button is-primary" v-if="u" @click="update" :disabled="!valid">Update</button>
            </div>
        </b-modal>
    </section>
</template>

<script>
export default {

    name: 'Education-CUD',
    props: {token: String, address: String, id: String, sectionid: String, c: Boolean, u: Boolean, d: Boolean, r: Boolean},
    data () {
        return {
            isModalActive: false,
            data: { school: '', degree: '', field_of_study: '', grade: '', from_year: '', to_year: '' },
        }
    },
    computed: {
        valid() {
            return this.data.school.length !== 0 && this.data.degree.length !== 0 && this.data.field_of_study.length !== 0 && this.data.grade.length !== 0 && this.data.from_year.length !== 0 && this.data.to_year.length !== 0;
        }
    },
    mounted() {
        if (this.u) {
            this.getData();
        }
    },
    methods: {
        createModal() {
            this.data = { school: '', degree: '', field_of_study: '', grade: '', from_year: '', to_year: ''};
            this.isModalActive = true;
        },
        updateModal() {
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
        create() {
            window.axios.post('/api/dashboard/contents/' + this.sectionid, this.data, { headers: { 'Authorization': 'Bearer ' + this.token } })
            .then(() => {
               this.isModalActive = false;
               this.$toast.open({
                    duration: 5000,
                    message: 'Created Successfully',
                    position: 'is-top',
                    type: 'is-success'
                });
                this.$emit('getData');
            })
            .catch(err => console.log(err));
        },
        getData() {
            const vm = this;
            window.axios.get('/api/dashboard/contents/' + vm.id, { headers: { 'Authorization': 'Bearer ' + vm.token } })
            .then(res => {
               console.log(res.data);
            })
            .catch(err => console.log(err));
        },
        update() {
            const vm = this;
            window.axios.put('/api/dashboard/contents/' + vm.id, vm.data, { headers: { 'Authorization': 'Bearer ' + vm.token } })
            .then(() => {
                this.isModalActive = false;
                this.$toast.open({
                    duration: 5000,
                    message: 'Updated Successfully',
                    position: 'is-top',
                    type: 'is-success'
                });
                this.$emit('getData');      
            })
            .catch(err => console.log(err));
        },
        destroy() {
            const vm = this;
            window.axios.delete('/api/dashboard/contents/' + vm.id, { headers: { 'Authorization': 'Bearer ' + vm.token } })
            .then(() => {
                this.$toast.open('Course deleted!');
                this.$emit('getData');                   
            })
            .catch(err => console.log(err));
        }
    }
}
</script>

<style lang="css" scoped>
</style>