
require('../bootstrap');

window.Vue = require('vue');
import Vuetify from 'vuetify'
 
Vue.use(Vuetify)

Vue.component('site-creator', require('../components/home-page/SiteCreator.vue'));
