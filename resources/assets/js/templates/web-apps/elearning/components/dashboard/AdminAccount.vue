<template>
    <v-container>
        
        <v-btn @click="register">Generate Admin Account</v-btn>
    </v-container>
</template>

<script>
    export default {
        name: 'AdminAccount',
        data() {
            return {
                name: '',
                password: ''
            }
        },
        methods: {
            
        }
    }
</script>
