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
    methods: {
        save() {
            
        }
    }
}
</script>

