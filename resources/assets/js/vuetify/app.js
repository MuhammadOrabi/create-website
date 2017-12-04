require('../bootstrap');

window.Vue = require('vue');
import Vuetify from 'vuetify'

window.Vue.use(Vuetify);
window.Vue.component('site-creator', require('../components/home-page/SiteCreator.vue'));
