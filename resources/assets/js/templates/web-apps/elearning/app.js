require('../../../bootstrap');
require('../../../firebase');

const Vue = require('vue');
import store from './store'

import Buefy from 'buefy';

Vue.use(Buefy);
Vue.store = store;

Vue.component('nav-bar', require('./components/nav/NavBar.vue'));
Vue.component('side-nav', require('./components/nav/SideNav.vue'));

const app = new Vue({
    el: '#app',
    store
});

window.Vue = Vue;

require('../../../sidebar');
