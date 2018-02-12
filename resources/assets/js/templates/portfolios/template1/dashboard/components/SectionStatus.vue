<template>
    <b-field label="Section Status">
        <b-switch v-model="state" @input="status" true-value="1" false-value="0"></b-switch>
    </b-field>
</template>

<script>
export default {

    name: 'SectionStatus',
    props: ['token', 'id', 'active'],
    data () {
        return {
            state: 1
        }
    },
    created() {
        this.getData();
    },
    watch: {
        active(val) {
            this.state = active;
        }
    },
    methods: {
        getData() {
            window.axios.get('/api/dashboard/sections/' + this.id, { headers: { 'Authorization': 'Bearer ' + this.token } })
            .then(res => {
                this.state = res.data.active;
                console.log(res.data);
            })
            .catch(err => console.log(err));
        },
        status() {
            window.axios.put('/api/dashboard/sections/' + this.id, {status: this.state}, { headers: { 'Authorization': 'Bearer ' + this.token } })
            .then(res => {
                console.log(res.data);
                this.$emit('getData');
            })
            .catch(err => console.log(err));
        }
    }
}
</script>

<style lang="css" scoped>
</style>