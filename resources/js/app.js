/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import VueInternationalization from 'vue-i18n';
import Locale from './vue-i18n-locales.generated';
//import Config from './config.js';
import BootstrapVue from 'bootstrap-vue';
import Vuelidate from 'vuelidate';
import Vue from 'vue'
import VueMaterial from 'vue-material'
import 'vue-material/dist/vue-material.min.css'

// asset imports

require('./bootstrap');

window.Vue = require('vue');
window.moment = require('moment');
const validators = require('vuelidate/lib/validators');

_.extend(window, validators);

Vue.use(Vuelidate);
Vue.use(BootstrapVue);
Vue.use(VueInternationalization);
Vue.use(VueMaterial);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

// API GOOGLE MAPS 
Vue.component('api_google_maps', require('./components/api_google_maps.vue').default);
// Progress bar
Vue.component('progress_bar', require('./components/progress_bar.vue').default);
//product
Vue.component('product', require('./components/products/product.vue').default);
Vue.component('product_modals_view', require('./components/products/modals/view.vue').default);
Vue.component('product_modals_new_edit', require('./components/products/modals/new-edit.vue').default);
//user
Vue.component('user_modals_combo_box', require('./components/users/modals/combo-box.vue').default);

//login
Vue.component('login_page', require('./components/pages/login.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const i18n = new VueInternationalization({
    locale: document.querySelector('html').lang,
    messages: Locale
});

const app = new Vue({
    el: '#app',
    i18n
});
