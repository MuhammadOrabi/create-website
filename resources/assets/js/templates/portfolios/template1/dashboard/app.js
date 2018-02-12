require('../../../../bootstrap');
require('../../../../firebase');

const Vue = require('vue');
import Buefy from 'buefy';
Vue.use(Buefy);

Vue.component('media', require('./components/Media.vue'));
Vue.component('home', require('./components/Home.vue'));
Vue.component('about', require('./components/About.vue'));
Vue.component('skill', require('./components/Skill.vue'));
Vue.component('education', require('./components/Education.vue'));
Vue.component('education-cud', require('./components/Education-CUD.vue'));
Vue.component('experience', require('./components/Experience.vue'));
Vue.component('experience-cud', require('./components/Experience-CUD.vue'));
Vue.component('contact', require('./components/Contact.vue'));
Vue.component('left-show-case', require('./components/LeftShowCase.vue'));
Vue.component('settings', require('./components/Settings.vue'));
Vue.component('section-status', require('./components/SectionStatus.vue'));

const app = new Vue({
    el: '#app',
});

window.Vue = Vue;
require('../../../../sidebar');
