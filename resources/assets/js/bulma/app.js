require('../bootstrap');

window.Vue = require('vue');

import Buefy from 'buefy';

window.Vue.use(Buefy);

window.Vue.component('site-creator', require('../components/SiteCreator'));

const app = new window.Vue({
    el: '#app'
});

require('./sidebar');
