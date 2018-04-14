<template>
    <section>
        <article class="media" v-for="comment in comments" :key="comment.id">
            <div class="media-content">
                <div class="content">
                    <p>
                        <strong>{{ comment.title }}</strong>
                        <small>{{ moment(comment.created_at).calendar() }}</small>
                        <br>{{ comment.content }}<br>
                    </p>
                </div>
            </div>
            <div class="media-right" v-if="comment.title === auth.name">
                <button @click="destroy(comment.id)" class="delete"></button>
            </div>
        </article>
        <article class="media">
            <div class="media-content">
                <div class="field">
                    <p class="control">
                        <textarea class="textarea" v-model="comment" placeholder="Add a comment..."></textarea>
                    </p>
                </div>
                <div class="field">
                    <p class="control">
                        <button class="button" @click="post" :disabled="!valid">Post comment</button>
                    </p>
                </div>
            </div>
        </article>
    </section>
</template>

<script>
    import moment from 'moment';
    export default {
        name: 'CommentSection',
        props: ['address', 'id'],
        data() {
            return {
                comments: [],
                comment: '',
            };
        },
        computed: {
            auth() {
                return this.$store.getters.session(this.address);                
            },
            valid() {
                return this.comment.length > 0;
            }
        },
        mounted() {
            this.getData();
        },
        methods: {
            moment,
            getData() {
                window.axios.get(`/api/contents/${this.id}`, { headers: { 'Authorization': `Bearer ${this.auth.token}` } })
                .then(res => {
                    let content = res.data;
                    this.comments = _.where(content.extras, {type: 'comment'});
                })
                .catch(err => console.log(err));
            },
            post() {
                let data = {
                    comment: this.comment,
                    user: this.auth.name
                };
                axios.post(`/api/dashboard/extras/contents/${this.id}`, data, { headers: { 'Authorization': `Bearer ${this.auth.token}` } })
                .then(res => {
                    this.comment = '';
                    this.getData();
                })
                .catch(err => console.log(err));
            },
            destroy(id) {
                axios.delete(`/api/dashboard/extras/contents/${id}`, { headers: { 'Authorization': `Bearer ${this.auth.token}` } })
                .then(res => {
                    this.getData();
                })
                .catch(err => console.log(err));
            }
        }
    }
</script>
