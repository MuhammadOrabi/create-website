<script>
    export default {
        props: ['slug', 'address'],
        data() {
            return {
            };
        },
        computed: {},
        beforeMount() {
            let auth = this.$store.getters.session(this.address);
            let slug = this.slug;
            if (auth) {
                if (slug === 'login' || slug === 'register') {
                    window.location = '/s/' + this.address;
                }
            } else {
                let slugs = ['profile', 'lesson'];
                if (slugs.includes(this.slug)) {
                    window.location = `/s/${this.address}/login`;
                }
            }
        },
        render() {
            return this.$slots.content[0];
        }
    }
</script>

<style lang="css" scoped></style>
