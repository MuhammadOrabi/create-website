<template>
    <div></div>
</template>

<script>
    export default {
        name: 'Auth',
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
        methods: {

        }
    }
</script>

<style lang="css" scoped></style>
