/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import Axios from 'axios';
import VueRouter from 'vue-router';
import swal from 'sweetalert2';
// import { Form, HasError, AlertError } from 'vform';

Vue.use(VueRouter);

window.swal = swal;

const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});
window.toast = toast;
// window.Form = Form;
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('example1-component', require('./components/Example1.vue').default);
Vue.component('user-component', require('./components/UsersComponent.vue').default);
Vue.component('crud-component', require('./components/CRUD_operation.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
window.Fire = new Vue();
let routes = [
    // { path: '/pages/add', component:  require('./components/AddPage.vue').default, meta:{menuname: ''} },
 ];
 const router = new VueRouter({
     mode: 'history',
     routes // short for `routes: routes`
 }); 
 
 const app = new Vue({
     el: '#app',
     data: {},
     router,
     mounted() { },
     methods: { },
 });
 