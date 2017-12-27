require('../../../bootstrap');
require('../../../firebase');

const Vue = require('vue');
import store from './store'

import Buefy from 'buefy';

Vue.use(Buefy);
Vue.store = store;

Vue.component('nav-bar', require('./components/site/nav/NavBar.vue'));
Vue.component('side-nav', require('./components/site/nav/SideNav.vue'));
Vue.component('site-register', require('./components/site/auth/Register.vue'));
Vue.component('site-login', require('./components/site/auth/Login.vue'));


const app = new Vue({
    el: '#app',
    store
});

window.Vue = Vue;

require('../../../sidebar');
