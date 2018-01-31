<template>
    <section class="flex-container columns">
        <div class="column is-7 is-offset-2">
            <div class="has-text-centered m-b-30">
                <h1 class="title has-text-primary">Have a question?</h1>
                <h1 class="subtitle has-text-info">Write your question or concern after the beep, and we'll reply soon enough.</h1>
            </div>
            <div class="columns">
                <div class="column">
                    <b-field  label="Name">
                        <b-input name="name" placeholder="John Doe" v-model.trim="data.name" expanded required></b-input>
                    </b-field>
                </div>
                <div class="column">
                    <b-field label="Email">
                        <b-input name="email" type="email" placeholder="john@example.com" v-model.trim="data.email" expanded required></b-input>
                    </b-field>
                </div>
            </div>
            <div class="columns">
                <div class="column">
                    <b-field  label="Subject">
                        <b-input name="subject" v-model.trim="data.subject" expanded required></b-input>
                    </b-field>
                </div>
                <div class="column">
                    <b-field  label="Topic">
                        <b-select placeholder="Select a topic" v-model.trim="data.topic" required>
                            <option value="Courses">Courses</option>
                            <option value="Articles">Articles</option>
                            <option value="Other">Other</option>
                        </b-select>
                    </b-field>
                </div>
            </div>


            <b-field  label="Message">
                <b-input type="textarea" v-model.trim="data.message" required></b-input>
            </b-field>

            <b-field ><!-- Label left empty for spacing -->
                <p class="control">
                    <button class="button is-primary" @click="send" :disabled="!valid">Send message</button>
                </p>
            </b-field>
        </div>
    </section>
</template>

<script>
export default {
    props: ['id'],
    data () {
        return {
            data: {
                name: null,
                email: null,
                subject: null,
                message: null,
                topic: null
            }
        }
    },
    computed: {
        valid() {
            return _.compact(_.values(this.data)).length === 5;
        }
    }, 
    methods: {
        send() {
            window.axios.post('/api/sections/' + this.id, this.data)
            .then(res => {
                this.data = {
                    name: null,
                    email: null,
                    subject: null,
                    message: null,
                    topic: null
                };
                this.$toast.open({
                        message: 'We\'ll reply soon enough',
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