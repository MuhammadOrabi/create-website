<template>
    <section>
        <b-field label="Add some Skills">
            <b-taginput v-model="skills" icon="label" placeholder="Add a Skill" @add="add" @remove="remove"></b-taginput>
        </b-field>
        <b-field group-multiline>
            <b-field v-for="(skill, i) in skills" :key="i">
                <p class="control">
                    <span class="button is-static">{{ skill }}</span>
                </p>
                <b-input type="number" min="0" max="100" placeholder="Percentage" v-model="data.skills[i].value" expanded></b-input>
                <p class="control">
                    <span class="button is-static">%</span>
                </p>
            </b-field>
        </b-field>
        <b-field><!-- Label left empty for spacing -->
            <p class="control">
                <button class="button is-primary" @click="save">Save</button>
            </p>
        </b-field>
    </section>
</template>

<script>
export default {

    name: 'Skill',
    props: ['token', 'id', 'address'],
    data () {
        return {
            skills: [],
            data: {
                skills: []
            }
        }
    },
    mounted() {
        this.getData();
    },
    methods: {
        add(val) {
            this.data.skills.push({ skill: val, value: null });
        },
        remove(val) {
            let skills = _.filter(this.data.skills, skill => {
                return skill.skill !== val;
            });
            this.data.skills = skills;
        },
        getData() {
            window.axios.get('/api/dashboard/sections/' + this.id, { headers: { 'Authorization': 'Bearer ' + this.token } })
            .then(res => {
                this.skills = [];
                this.data.skills = [];
                let skills = res.data.contents;
                _.each(skills, skill => {
                    this.skills.push(skill.type);
                    this.data.skills.push({ skill: skill.type, value: skill.content });
                });
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