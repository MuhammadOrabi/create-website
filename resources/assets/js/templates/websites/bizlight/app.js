require('../../../bootstrap');

import Popper from 'popper.js';
window.Popper = Popper;

require('bootstrap');


window.Vue = require('vue');
Vue.component('home-page', require('./components/dashboard/HomePage.vue'));
Vue.component('about', require('./components/dashboard/About.vue'));
Vue.component('services', require('./components/dashboard/Services.vue'));

const app = new Vue({
	el: '#app'
});