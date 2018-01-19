<template>
	<section>
		<b-field label="What do you want to have on your home page?">
			<div class="block">
	            <b-checkbox v-model="checkboxGroup" native-value="showcase">Show Case Image</b-checkbox>
	            <b-checkbox v-model="checkboxGroup" native-value="articles">Leatest Articles</b-checkbox>
	            <b-checkbox v-model="checkboxGroup" native-value="courses">Leatest Courses</b-checkbox>
	        </div>
        </b-field>
        <hr>
        <section>
        	<h1 class="subtitle">Show Case Image</h1>
        	
        </section>
	</section>
</template>

<script>
export default {

  	name: 'homePage',
  	props: ['address', 'token'],
  	data () {
    	return {
    		checkboxGroup: ['showcase', 'articles', 'courses']
    	}
  	}
}
</script>

<style lang="css" scoped>
</style>