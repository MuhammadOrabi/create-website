<template>
    <b-field label="Section Status">
        <div class="block">
            <b-radio v-model="state" native-value="1">Enable</b-radio>
            <b-radio v-model="state" native-value="0">Disable</b-radio>
        </div>
    </b-field>
</template>

<script>
export default {

    name: 'SectionStatus',
    props: ['token', 'id'],
    data () {
        return {
            state: 1,
        }
    },
    watch:{
        state(val) {
            this.status();
        }
    },
    created() {
        this.getData();
    },
    methods: {
        getData() {
            window.axios.get('/api/dashboard/sections/' + this.id, { headers: { 'Authorization': 'Bearer ' + this.token } })
            .then(res => {                
                this.state = res.data.active;
            })
            .catch(err => console.log(err));
        },
        status() {
            window.axios.put('/api/dashboard/sections/' + this.id, {status: this.state}, { headers: { 'Authorization': 'Bearer ' + this.token } })
            .then(res => {
                this.$emit('getData');
            })
            .catch(err => console.log(err));
        }
    }
}
</script>

<style lang="css" scoped>
</style>