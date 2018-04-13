require('../../../../bootstrap');
require('../../../../vue-froala-wysiwyg');

import Vue from 'vue';
import Buefy from 'buefy';
import VueFroala from 'vue-froala-wysiwyg';

// chartjs package
require('chart.js');
// vue-charts package
require('hchs-vue-charts');
Vue.use(VueCharts);
Vue.use(VueFroala);

Vue.use(Buefy);

Vue.component('media', require('./components/Media.vue'));
Vue.component('pages', require('./components/Pages.vue'));
Vue.component('pages-crud', require('./components/PagesCRUD.vue'));
Vue.component('items', require('./components/Items.vue'));
Vue.component('items-cu', require('./components/Items-CU.vue'));
Vue.component('footer-settings', require('./components/Footer.vue'));
Vue.component('settings', require('./components/Settings.vue'));
// Vue.component('analytics-page', require('./components/AnalyticsPage.vue'));

const app = new Vue({
    el: '#app'
});

window.Vue = Vue;
require('../../../../sidebar');
