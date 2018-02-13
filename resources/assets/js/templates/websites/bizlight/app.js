require('../../../bootstrap');
require('../../../firebase');

import Vue from 'vue';
import Buefy from 'buefy';

Vue.use(Buefy);

Vue.component('media', require('./components/Media.vue'));
Vue.component('home-page', require('./components/home-page/Page.vue'));

const app = new Vue({
	el: '#app'
});

window.Vue = Vue;
require('../../../sidebar');
