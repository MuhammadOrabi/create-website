require('../../../bootstrap');
require('../../../firebase');

window.Vue = require('vue');
import Vuetify from 'vuetify'
import store from './store'
import VeeValidate from 'vee-validate';

 
Vue.use(Vuetify);
Vue.use(VeeValidate);
Vue.component('home-page', require('./components/dashboard/HomePage.vue'));
Vue.component('about', require('./components/dashboard/About.vue'));
Vue.component('news', require('./components/dashboard/News.vue'));
Vue.component('media', require('./components/dashboard/Media.vue'));

Vue.component('site-signin', require('./components/site/Signin.vue'));
Vue.component('site-signup', require('./components/site/Signup.vue'));

Vue.store = store;
