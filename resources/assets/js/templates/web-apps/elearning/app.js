require('../../../bootstrap');
require('../../../firebase');
require('../../../vue-froala-wysiwyg');


const Vue = require('vue');
import VueFroala from 'vue-froala-wysiwyg';
import store from './store';
import Buefy from 'buefy';

Vue.use(Buefy);
Vue.use(VueFroala);

Vue.store = store;
// Site Components
Vue.component('nav-bar', require('./components/site/nav/NavBar.vue'));
Vue.component('side-nav', require('./components/site/nav/SideNav.vue'));
Vue.component('site-register', require('./components/site/auth/Register.vue'));
Vue.component('site-login', require('./components/site/auth/Login.vue'));
Vue.component('auth', require('./components/site/auth/Auth.vue'));

// Dashboard Components
Vue.component('media', require('./components/dashboard/Media.vue'));
Vue.component('users', require('./components/dashboard/Users.vue'));
Vue.component('courses', require('./components/dashboard/Courses.vue'));
Vue.component('courses-crud', require('./components/dashboard/Courses-CRUD.vue'));
Vue.component('lessons', require('./components/dashboard/Lessons.vue'));
Vue.component('lessons-cu', require('./components/dashboard/Lessons-CU.vue'));
Vue.component('articles', require('./components/dashboard/Articles.vue'));
Vue.component('articles-cu', require('./components/dashboard/Articles-CU.vue'));
Vue.component('home-page', require('./components/dashboard/homePage.vue'));



const app = new Vue({
    el: '#app',
    store
});

window.Vue = Vue;

require('../../../sidebar');
