/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import moment from 'moment'

Vue.filter('formatDate', function (value) {
    if (value) {
        return moment(String(value)).format('MM/DD/YYYY hh:mm')
    }
});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('login',require('./components/Login.vue').default);
Vue.component('app',require('./components/App.vue').default);
Vue.component('dashboard',require('./components/admin/Dashboard.vue').default);
Vue.component('home',require('./components/front/Home.vue').default);
Vue.component('category',require('./components/front/CategoryDetail.vue').default);
Vue.component('detail',require('./components/front/ArticleDetail.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import Vue from 'vue';
import store from './store.js'
import vuetify from './plugins/vuetify';
// import VueMeta from 'vue-meta';

// Vue.use(VueMeta);
const app = new Vue({
    el: '#app',
    store,
    vuetify
});
