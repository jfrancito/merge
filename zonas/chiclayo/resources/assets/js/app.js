
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
// import VueCurrencyFilter from 'vue-currency-filter

// Vue.use(VueCurrencyFilter)

require('./bootstrap');

window.Vue = require('vue');
import VueApexCharts from 'vue-apexcharts';
import Datepicker from 'vuejs-datepicker';
import VueSweetalert2 from 'vue-sweetalert2';
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('panelcuentas', require('./components/PanelCuentas.vue'));
Vue.component('paneldetraccion', require('./components/PanelDetraccion.vue'));
Vue.component('apexchart', VueApexCharts);
Vue.component('datepicker', Datepicker);

Vue.component('chartsaldo', require('./components/ChartSaldo.vue'));
   
Vue.use(VueSweetalert2);

const app = new Vue({
    el: '#app',
    data: {
        menu : 0,
        ruta: 'http://10.1.50.2:8080/web'
    }
});
