
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
//import VueGraph from 'vue-graph';
require('./bootstrap');

window.Vue = require('vue');
//Vue.use(VueGraph);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('transaction-component', require('./components/TransactionComponent.vue'));

console.log('LOADING VUE');

const app = new Vue({
    el: '#app'
});
