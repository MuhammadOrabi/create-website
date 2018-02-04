require('../../../../bootstrap');
require('../../../../firebase');

const Vue = require('vue');
import Buefy from 'buefy';
Vue.use(Buefy);

const app = new Vue({
    el: '#app',
});

window.Vue = Vue;
require('../../../../sidebar');
