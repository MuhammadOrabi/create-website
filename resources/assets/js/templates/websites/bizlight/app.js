require('../../../bootstrap');
require('../../../firebase');
require('../../../vue-froala-wysiwyg');

import VueFroala from 'vue-froala-wysiwyg';
import Popper from 'popper.js';
window.Popper = Popper;

require('bootstrap');


const Vue = require('vue');
Vue.use(VueFroala);

Vue.component('home-page', require('./components/dashboard/HomePage.vue'));
Vue.component('about', require('./components/dashboard/About.vue'));
Vue.component('services', require('./components/dashboard/Services.vue'));
Vue.component('media', require('./components/dashboard/Media.vue'));
Vue.component('navigation', require('./components/dashboard/Navigation.vue'));

const app = new Vue({
	el: '#app'
});

window.Vue = Vue;
