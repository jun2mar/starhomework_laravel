/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import { Form, HasError, AlertError } from 'vform';
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
window.Form = Form;

import moment from 'moment';
Vue.filter('setDate', function(date) {
    return moment(date).format('MMM. DD, YYYY');
});

import VueProgressBar from 'vue-progressbar';
Vue.use(VueProgressBar, {
    color: '#38c172',
    failedColor: 'red',
    height: '2px'
});

// import Popper from 'popper.js/dist/umd/popper.js';
// window.Popper = Popper;

import PayPal from 'vue-paypal-checkout';
Vue.component('PayPal', PayPal);
window.paypal_sandbox = 'AesUy1zF6nRfO0B4R7U-swa4aHqF6Wls_bfFdB4dX42KOpfQAfWtdf2UCEk10aE5UwN2_LzRSaKHX9G_';
window.paypal_production = 'AYvt5GUk2ivtDx8X-fKEaY_WGHEsiATMI-LcLbGBS8rWGWBIgA5eKoG4WcK8h33P92ey7lmvrQIXYwja';

import Swal from 'sweetalert2'
window.Swal = Swal;
const toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 5000,
    timerProgressBar: true,
    onOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});
window.toast = toast;

import VueQRCodeComponent from 'vue-qrcode-component';
Vue.component('qr-code', VueQRCodeComponent);

import VueCountdownTimer from 'vuejs-countdown-timer';
Vue.use(VueCountdownTimer);
// Vue.component('vue-countdown-timer', VueCountdownTimer);


window.glob_error = "There is a problem with your request";


Vue.component('pagination', require('laravel-vue-pagination'));

Vue.filter('formatDate', function(created) {
    return moment(created).format('MMM. DD, YYYY');
});

Vue.filter('formatDateTime', function(created) {
    return moment(created).format('MMM. DD, YYYY hh:mm a');
});

Vue.filter('nullVal', function(value) {
    return (value) ? value : 'N/A';
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

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('profile-component', require('./components/account/ProfileComponent.vue').default);
Vue.component('homeworklist-component', require('./components/account/HomeworkListComponent.vue').default);
Vue.component('homework-template-component', require('./components/account/HomeworkAddEditComponent.vue').default);
// Vue.component('homework-order-view-component', require('./components/account/HomeworkOrderView.vue').default);

// ORDER VIEW COMPONENTS
Vue.component('homework-order-view-timer-component', require('./components/account/HomeworkOrderView/OrderTimer.vue').default);
Vue.component('homework-order-view-chat-component', require('./components/account/HomeworkOrderView/OrderChat.vue').default);



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
