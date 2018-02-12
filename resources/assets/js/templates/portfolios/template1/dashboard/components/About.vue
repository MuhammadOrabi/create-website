<template>
    <section>
        <section-status :token="token" :id="id" @getData="getData" :active="active"></section-status>
        <b-field label="About Paragraph">
            <b-input v-model.trim="data.about" type="textarea" :disabled="!active"></b-input>
        </b-field>
        <hr>
        <h1 class="subtitle">Personal Details</h1>
        <b-field grouped>
            <b-field label="Full Name" expanded>
                <b-input v-model.trim="data.name" placeholder="Jone Doe" expanded :disabled="!active"></b-input>
            </b-field>
            <b-field label="Father's Name" expanded>
                <b-input v-model.trim="data.father" placeholder="Jone Doe" :disabled="!active"></b-input>
            </b-field>
        </b-field>

        <b-field grouped>
            <b-field label="Address" expanded>
                <b-input v-model.trim="data.address" placeholder="123 6th St. Melbourne, FL 32904. INDIA" expanded :disabled="!active"></b-input>
            </b-field>
            <b-field label="Zip Code" expanded>
                <b-input v-model.trim="data.zip" placeholder="12345" :disabled="!active"></b-input>
            </b-field>
        </b-field>

        <b-field grouped>
            <b-field label="Phone Number 1" expanded>
                <b-input v-model.trim="data.number1" placeholder="+0 123456789" expanded :disabled="!active"></b-input>
            </b-field>
            <b-field label="Phone Number 2" expanded>
                <b-input v-model.trim="data.number2" placeholder="+0 123456789" :disabled="!active"></b-input>
            </b-field>
        </b-field>

        <b-field grouped>
            <b-field label="Email" expanded>
                <b-input v-model.trim="data.email" placeholder="email@app.com" expanded :disabled="!active"></b-input>
            </b-field>
            <b-field label="Website" expanded>
                <b-input v-model.trim="data.website" placeholder="https://app.io" :disabled="!active"></b-input>
            </b-field>
        </b-field>
        <hr>
        <b-field label="Hire me Paragraph">
            <b-input v-model.trim="data.hireme" type="textarea" :disabled="!active"></b-input>
        </b-field>

        <b-field><!-- Label left empty for spacing -->
            <p class="control">
                <button class="button is-primary" @click="save" :disabled="!active">Save</button>
            </p>
        </b-field>

    </section>
</template>

<script>
export default {

    name: 'About',
    props: ['token', 'id', 'address'],
    data () {
        return {
            active: 1,
            data: {
                about: '',
                name: '',
                father: '',
                address: '',
                zip: '',
                number1: '',
                number2: '',
                email: '',
                website: '',
                hireme: '',
            }
        }
    },
    mounted() {
        this.getData();
    },
    methods: {
        getData() {
            window.axios.get('/api/dashboard/sections/' + this.id, { headers: { 'Authorization': 'Bearer ' + this.token } })
            .then(res => {
                this.active = res.data.active;
                let about = _.findWhere(res.data.contents, {type: 'about'});
                let name = _.findWhere(res.data.contents, {type: 'name'});
                let father = _.findWhere(res.data.contents, {type: 'father'});
                let address = _.findWhere(res.data.contents, {type: 'address'});
                let zip = _.findWhere(res.data.contents, {type: 'zip'});
                let number1 = _.findWhere(res.data.contents, {type: 'number1'});
                let number2 = _.findWhere(res.data.contents, {type: 'number2'});
                let email = _.findWhere(res.data.contents, {type: 'email'});
                let website = _.findWhere(res.data.contents, {type: 'website'});
                let hireme = _.findWhere(res.data.contents, {type: 'hireme'});
                this.data.about = about ? about.content : null;
                this.data.name = name ? name.content : null;
                this.data.father = father ? father.content : null;
                this.data.address = address ? address.content : null;
                this.data.zip = zip ? zip.content : null;
                this.data.number1 = number1 ? number1.content : null;
                this.data.number2 = number2 ? number2.content : null;
                this.data.email = email ? email.content : null;
                this.data.website = website ? website.content : null;
                this.data.hireme = hireme ? hireme.content : null;
            })
            .catch(err => console.log(err));
        },
        save() {
            window.axios.put('/api/dashboard/sections/' + this.id, this.data, { headers: { 'Authorization': 'Bearer ' + this.token } })
            .then(res => {
                this.$toast.open({
                    message: 'Saved Successfully',
                    type: 'is-success'
                });
                this.getData();
            })
            .catch(err => console.log(err));
        }
    }
}
</script>

<style lang="css" scoped>
</style>