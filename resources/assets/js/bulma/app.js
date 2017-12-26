require('../bootstrap');

const Vue = require('vue');

import Buefy from 'buefy';

Vue.use(Buefy);

Vue.component('site-creator', require('../components/SiteCreator'));

const app = new Vue({
    el: '#app'
});

window.Vue = Vue;

require('../sidebar');
