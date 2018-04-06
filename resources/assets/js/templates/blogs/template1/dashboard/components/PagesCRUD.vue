<template>
    <section>
        <div class="buttons has-addons is-centered">
            <span class="button is-link is-inverted" v-if="c" @click="createModal">
                <b-icon pack="fa" icon="plus"></b-icon>
            </span>
            <a class="button is-info is-inverted" v-if="r" :href="`/s/${address}/course/${sectionid}`" target="_blank">
                <b-icon pack="fa" icon="eye"></b-icon>
            </a>
            <span class="button is-primary is-inverted" v-if="u" @click="updateModal">
                <b-icon pack="fa" icon="pencil-square-o"></b-icon>
            </span>
            <span class="button is-danger is-inverted" v-if="d" @click="deleteDialog">
                <b-icon pack="fa" icon="trash-o"></b-icon>
            </span>
        </div>
        <b-modal :active.sync="isModalActive">
            <div class="box">
                <h1 v-if="c" class="title is-1 has-text-centered">Create Page</h1>                
                <h1 v-if="u" class="title is-1 has-text-centered">Update Page</h1>
                <b-field label="Title">
                    <b-input v-model.trim="data.title" placeholder="Title"></b-input>
                </b-field>
                <b-field label="Type">
                    <b-input v-model.trim="data.type" placeholder="Type"></b-input>
                </b-field>
                 <b-field label="Order">
                    <b-input type="number" v-model.trim="data.order" placeholder="Order"></b-input>
                </b-field>
                <div class="field">
                    <b-field label="Active">                
                        <b-switch v-model="data.active">
                            {{ data.active }}
                        </b-switch>
                    </b-field>
                </div>
                <button class="button is-primary" v-if="c" @click="create" :disabled="!valid">Create</button>
                <button class="button is-primary" v-if="u" @click="update" :disabled="!valid">Update</button>
            </div>    
        </b-modal>
    </section>
</template>

<script>
    const _ = window._;
    export default {
        name: 'PagesCRUD',
        props: {token: String, address: String, id: String, sectionid: String, c: Boolean, u: Boolean, d: Boolean, r: Boolean},
        data() {
            return {
                isModalActive: false,
                data: {
                    title: '',
                    type: '',
                    order: 0,
                    active: true,
                },
            };
        },
        computed: {
            valid() {
                return this.data.title !== '' && this.data.type !== '';
            }
        },
        mounted() {
            if (this.u) {
                this.getData();
            }
        },
        methods: {
            createModal() {
                this.data = {
                    title: '',
                    type: '',
                    order: 0,
                    active: true
                };
                this.isModalActive = true;
            },
            updateModal() {
                this.isModalActive = true;  
            },
            deleteDialog() {
                this.$dialog.confirm({
                    title: 'Deleting Page',
                    message: 'Are you sure you want to <b>delete</b> this Page?<br> This action cannot be undone.',
                    confirmText: 'Delete Page',
                    type: 'is-danger',
                    hasIcon: true,
                    onConfirm: () => this.destroy()
                });
            },
            create() {
                window.axios.post(`/api/dashboard/sections/${this.id}`, this.data, { headers: { 'Authorization': `Bearer ${this.token}` } })
                .then(res => {
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
                window.axios.get(`/api/dashboard/sections/${this.sectionid}`, { headers: { 'Authorization': `Bearer ${this.token}` } })
                .then(res => {
                    let section = res.data;
                    this.data = {
                        title: section.title,
                        type: section.type,
                        order: section.order,
                        active: section.active ? 'true' : 'false'
                    };
                })
                .catch(err => console.log(err));
            },
            update() {
                const vm = this;
                window.axios.put('/api/dashboard/sections/' + vm.sectionid, vm.data, { headers: { 'Authorization': 'Bearer ' + vm.token } })
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
                window.axios.delete('/api/dashboard/sections/' + vm.sectionid, { headers: { 'Authorization': 'Bearer ' + vm.token } })
                .then(() => {
                    this.$toast.open({
                        duration: 5000,
                        message: 'Deleted Successfully',
                        position: 'is-top',
                        type: 'is-success'
                    });
                    this.$emit('getData');                   
                })
                .catch(err => console.log(err));
            }
        }
    }
</script>

<style lang="css" scoped></style>
