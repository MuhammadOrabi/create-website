<template>
    <section>
        <section class="columns">
            <div class="column">
                <b-field label="Site Name">
                    <b-input placeholder="Name .." v-model="data.name"></b-input>
                </b-field>
            </div>
        </section>
        <button class="button is-success" @click="save">Save</button>
    </section>
</template>

<script>
export default {
    name: 'Settings',
    props: ['address', 'token', 'id'],
    data () {
        return {
            data: { name: '' }
        }
    },
    mounted() {
        this.getData();
    },
    methods: {
        getData() {
            window.axios.get('/api/sites/info/site-info/' + this.address)
            .then(res => {
                this.data.name = res.data.name;
            })
            .catch(err => console.log(err));
        },
        save() {
            window.axios.put('/api/dashboard/sites/' + this.id, this.data, { headers: { 'Authorization': 'Bearer ' + this.token } })
            .then(res => {
                this.getData();
                this.$toast.open({
                    message: 'Saved Successfully',
                    type: 'is-success'
                });
            })
            .catch(err => console.log(err));
        }
    }
}
</script>

<style lang="css" scoped>
</style>