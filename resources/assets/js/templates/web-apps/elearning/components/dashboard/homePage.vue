<template>
	<section>
		<b-field label="What do you want to have on your home page?">
			<div class="block">
	            <b-checkbox v-model="checkboxGroup" native-value="showcase">Show Case Image</b-checkbox>
	            <b-checkbox v-model="checkboxGroup" native-value="articles">Leatest Articles</b-checkbox>
	            <b-checkbox v-model="checkboxGroup" native-value="courses">Leatest Courses</b-checkbox>
	        </div>
        </b-field>
        <button class="button is-link is-rounded" @click="save">Save</button>
        <hr>
        <b-modal :active.sync="isMediaModalActive" >
            <media v-bind="mediaProps" :imgUrl.sync="img" :active.sync="isMediaModalActive"></media>
        </b-modal>
        <button class="button is-warning is-rounded" @click="isMediaModalActive = true">Add Show Case Image</button>    
        <section class="p-t-20 columns is-multiline is-centered">
            <div class="column is-three-quarters" v-if="img">
                <div class="notification">
                    <button class="delete" @click="img = null"></button>
                    <figure class="image is-2by1">
                        <img :src="img">
                    </figure>
                </div>
            </div>
        </section>
	</section>
</template>

<script>
export default {

  	name: 'homePage',
  	props: ['address', 'token', 'id'],
  	data () {
    	return {
    		checkboxGroup: [],
            isMediaModalActive: false,
            mediaProps: {
                address: this.address,
                token: this.token
            },
            img: null
    	}
  	},
    mounted() {
        this.getData();
    },
    methods: {
        getData() {
            window.axios.get('/api/dashboard/pages/' + this.id, { headers: { 'Authorization': 'Bearer ' + this.token } })
            .then(res => {
                this.checkboxGroup = _.pluck(_.where(res.data.sections, {active: 1}), 'title');
                let showcase = _.findWhere(res.data.sections, {title: 'showcase'});
                let img = _.findWhere(showcase.contents, {type: 'img'});
                this.img = img ? img.content : null;
            })
            .catch(err => console.log(err));
        },
        save() {
            let data = {img: this.img, sections: this.checkboxGroup};
            window.axios.put('/api/dashboard/pages/' + this.id, data, { headers: { 'Authorization': 'Bearer ' + this.token } })
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