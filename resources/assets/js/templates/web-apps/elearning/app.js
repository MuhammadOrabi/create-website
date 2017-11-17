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
Vue.component('contact', require('./components/dashboard/Contact.vue'));
Vue.component('media', require('./components/dashboard/Media.vue'));
Vue.component('sign-up', require('./components/dashboard/SignUp.vue'));
Vue.component('courses', require('./components/dashboard/Courses.vue'));
Vue.component('create-update-course', require('./components/dashboard/CreateUpdateCourse.vue'));

Vue.component('site-signin', require('./components/site/Signin.vue'));
Vue.component('site-signup', require('./components/site/Signup.vue'));
Vue.component('site-home-page', require('./components/site/homePage.vue'));
Vue.component('site-contact', require('./components/site/Contact.vue'));
Vue.component('site-news', require('./components/site/News.vue'));
Vue.component('site-courses', require('./components/site/Courses.vue'));
Vue.component('site-course', require('./components/site/Course.vue'));
Vue.component('site-lesson', require('./components/site/Lesson.vue'));

Vue.store = store;
