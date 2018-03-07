<template>
    <b-field label="About">
        <div class="block">
             <b-field label="Paragraph">
                <b-input type="textarea" v-model.trim="paragraph" ></b-input>
            </b-field>
            <b-field horizontal>
                <p class="control">
                    <button class="button is-success" @click="save" minlength="20" :disabled="paragraph.length < 20">
                        <b-icon pack="fa" icon="check"></b-icon>
                        <span>Save</span>
                    </button>
                </p>
            </b-field>
        </div>
    </b-field>
</template>

<script>
export default {
    name: 'About',
    props: ['id', 'token'],
    data () {
        return {
            paragraph: ''
        }
    },
    mounted() {
        this.getData();
    },
    methods: {
        getData() {
            window.axios.get(`/api/dashboard/pages/${this.id}`, { headers: { 'Authorization': `Bearer ${this.token}` } })
            .then(res => {
                let about = _.findWhere(res.data.sections, {title: 'about'});    
                if (about) {
                    let paragraph = _.findWhere(about.contents, {type: 'paragraph'});                
                    this.paragraph = paragraph ? paragraph.content : '';
                }                            
            })
            .catch(err => console.log(err));
        },
        save() {
            let data = { paragraph: this.paragraph };
            window.axios.put(`/api/dashboard/pages/${this.id}`, data, { headers: { 'Authorization': `Bearer ${this.token}` } })
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

