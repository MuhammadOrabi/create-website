require('../../../bootstrap');

import Vue from 'vue';
import Buefy from 'buefy';

// chartjs package
require('chart.js');
// vue-charts package
require('hchs-vue-charts');
Vue.use(VueCharts);

Vue.use(Buefy);

Vue.component('media', require('./components/Media.vue'));
Vue.component('home-page', require('./components/home-page/Page.vue'));
Vue.component('about', require('./components/About.vue'));
Vue.component('Contact', require('./components/Contact.vue'));
Vue.component('services', require('./components/Services.vue'));
Vue.component('navigation', require('./components/Navigation.vue'));
Vue.component('settings', require('./components/Settings.vue'));
Vue.component('section-status', require('./components/home-page/SectionStatus.vue'));
Vue.component('analytics-page', require('./components/AnalyticsPage.vue'));

const app = new Vue({
	el: '#app'
});

window.Vue = Vue;
require('../../../sidebar');
